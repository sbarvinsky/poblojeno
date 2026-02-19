<?php
/**
 * Walker Menu for Monobase
 *
 * @package Monobase
 */

class Mono_Walker_Side_Menu extends Walker_Nav_Menu {

	private $current_parent_id = 0;
	private $opened_submenu_parent = null;

	// Open submenu <ul>
	public function start_lvl( &$output, $depth = 0, $args = [] ) {
		$indent  = str_repeat( "\t", $depth );
		$id_attr = $this->current_parent_id ? ' id="sub-menu-' . (int) $this->current_parent_id . '"' : '';

		$should_open = $this->opened_submenu_parent && $this->opened_submenu_parent === $this->current_parent_id;
		$hidden_attr = $should_open ? '' : ' hidden';

		$output .= "\n$indent<ul class=\"sub-menu\"$id_attr$hidden_attr>\n";
	}

	// Close submenu </ul>
	public function end_lvl( &$output, $depth = 0, $args = [] ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
		// Reset only the marker that couples to this level
		$this->current_parent_id = null;
	}

	// Render item
	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$classes      = (array) $item->classes;
		$has_children = in_array( 'menu-item-has-children', $classes, true );
		$item_classes = implode( ' ', array_map( 'sanitize_html_class', $classes ) );

		$data_tooltip    = '';
		$classes_tooltip = '';
		if ( ! empty( $item->attr_title ) ) {
			$classes_tooltip = ' has-tooltip on-bottom';
			$data_tooltip    = ' data-tooltip="' . esc_attr( $item->attr_title ) . '"';
		}

		$check_user = apply_filters( 'monobase_menu_item_check_user', false, $item->ID );

		if ( $check_user ) {
			return '';
		}

		$count = null;
		if ( $item->type === 'taxonomy' && taxonomy_exists( $item->object ) ) {
			$count = $this->term_total_count( (int) $item->object_id, $item->object, 'any' );
		}

		$current_id = get_queried_object_id();

		$is_active = false;

		if ( $item->type === 'taxonomy' ) {
			$is_active = $this->is_tax_item_active( $item );

		} elseif ( $item->type === 'post_type' ) {

			if ( $item->object === 'page' ) {
				if ( is_page() ) {
					$is_active = ( (int) $item->object_id === (int) $current_id );
				}

			} else {
				if ( is_singular( $item->object ) ) {
					$is_active = ( (int) $item->object_id === (int) $current_id );
				}
			}

		}

		$active = $is_active ? ' current-menu-item' : '';

		$output .= '<li id="menu-item-' . (int) $item->ID . '" class="' . esc_attr( $item_classes . $active ) . '">';

		if ( $has_children ) {
			$this->current_parent_id = $item->ID;

			$is_current_parent = array_intersect(
				[ 'current-menu-parent', 'current-menu-ancestor' ],
				$classes
			);

			$expanded = ! empty( $is_current_parent );
			if ( $expanded ) {
				$this->opened_submenu_parent = (int) $item->ID;
			}

			$submenu_id = 'sub-menu-' . (int) $item->ID;

			// Button label/toggle
			$btn_class = 'btn-toggle' . ( $expanded ? ' is-active' : '' );

			$output .= '<button class="' . esc_attr( $btn_class . $classes_tooltip ) . '" aria-haspopup="true" aria-expanded="' . ( $expanded ? 'true' : 'false' ) . '" aria-controls="' . esc_attr( $submenu_id ) . '"';
			$output .= $data_tooltip . '>';

			$output .= apply_filters( 'monobase_menu_item_icon', '', $item->ID, $item->title );

			$output .= apply_filters( 'monobase_menu_item_hide_title', $item->title, $item->ID );
			$output .= '<span class="mb-icon mb-icon-chevron-right" aria-hidden="true"></span>';
			$output .= '</button>';

		} else {
			// Leaf → normal link
			$atts = [
				'target' => $item->target ?: '',
				'rel'    => $item->xfn ?: '',
				'href'   => $item->url ?: '',
			];

			if ( isset( $atts['href'] ) && $atts['href'] === '#wp-logout' ) {
				$atts['href'] = wp_logout_url( home_url() );
			}

			$atts = array_filter( $atts, fn( $v ) => $v !== '' );

			$attr_html = '';
			foreach ( $atts as $name => $val ) {
				$attr_html .= ' ' . $name . '="' . esc_attr( $val ) . '"';
			}

			$output .= '<a' . $attr_html . $data_tooltip;
			$output .= ! empty( $classes_tooltip ) ? ' class="' . esc_attr( $classes_tooltip ) . '"' : '';
			$output .= '>';

			$output .= apply_filters( 'monobase_menu_item_icon', '', $item->ID, $item->title );
			$output .= apply_filters( 'monobase_menu_item_hide_title', $item->title, $item->ID );

			if ( isset( $count ) ) {
				$output .= '<span class="count">' . esc_html( $count ) . '</span>';
			}
			$output .= '</a>';
		}
	}

	public function end_el( &$output, $item, $depth = 0, $args = [] ) {
		$output .= "</li>\n";
	}

	public function term_total_count( int $term_id, string $taxonomy, $post_type = 'any' ): int {
		$q = new WP_Query( [
			'post_type'           => $post_type,         // e.g. 'post' or ['post','product'] or 'any'
			'post_status'         => 'publish',
			'posts_per_page'      => 1,                  // fetch minimum
			'fields'              => 'ids',              // no heavy objects
			'no_found_rows'       => false,              // IMPORTANT: we need found_posts
			'ignore_sticky_posts' => true,
			'tax_query'           => [
				[
					'taxonomy'         => $taxonomy,
					'field'            => 'term_id',
					'terms'            => $term_id,
					'include_children' => true,          // include all descendants
					'operator'         => 'IN',
				],
			],
		] );

		return (int) $q->found_posts;
	}

	public function is_tax_item_active( WP_Post $item ): bool {
		if ( $item->type !== 'taxonomy' || ! taxonomy_exists( $item->object ) ) {
			return false;
		}


		$term_id = (int) $item->object_id;   // term in menu
		$tax     = $item->object;

		if ( is_tax( $tax ) || is_category() || is_tag() ) {

			$q = get_queried_object(); // WP_Term
			if ( $q instanceof WP_Term ) {
				if ( $q->term_id === $term_id ) {
					return true;
				}
				$anc = get_ancestors( $q->term_id, $tax, 'taxonomy' );

				return in_array( $term_id, $anc, true );
			}
		}

		if ( is_singular() ) {
			$post_id = get_the_ID();
			// collect all terms attached to post within this taxonomy
			$terms = wp_get_post_terms( $post_id, $tax, [ 'fields' => 'ids' ] );
			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				return false;
			}

			// fast check: post has the exact term
			if ( in_array( $term_id, $terms, true ) ) {
				return true;
			}

			// check descendants: does post have any term that is a descendant of $term_id?
			foreach ( $terms as $t_id ) {
				$anc = get_ancestors( $t_id, $tax, 'taxonomy' );
				if ( in_array( $term_id, $anc, true ) ) {
					return true;
				}
			}
		}

		return false;
	}


}

