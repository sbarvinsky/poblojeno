<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Monobase
 */

function monobase_check_home_page_teplate_include() {
	$option = get_theme_mod( 'monobase_home', [] );

	return ( ! empty( $option['title'] ) || ! empty( $option['excerpt'] ) || ! empty( $option['content'] ) || has_nav_menu( 'homepage' ) );
}

function monobase_post_has_date() {
	$appearance = get_theme_mod( 'monobase_appearance' );

	return ! empty( $appearance['post_date'] );
}

function monobase_button_switcher_aria_label() {
	if ( is_front_page() && is_home() ) {
		return esc_attr__( 'Page', 'monobase' );
	}

	return esc_attr__( 'Category', 'monobase' );
}

function monobase_archive_summary() {
	$description = term_description();
	if ( ! empty( $description ) ) {
		$summary = monobase_get_first_paragraph( $description );
		if ( ! empty( $summary ) ) {
			echo '<div class="entry-summary">' . wp_kses_post( $summary ) . '</div>';
		}
	};
}

function monobase_archive_description() {
	$description = term_description();
	if ( ! empty( $description ) ) {
		$content = $description;
		if ( preg_match( '/<p>.*?<\/p>/is', $description, $matches ) ) {
			$content = preg_replace( '/<p>.*?<\/p>/is', '', $description, 1 );
		}
		if ( ! empty( $content ) ) {
			echo '<div class="entry-content">' . wp_kses_post( $content ) . '</div>';
		}
	}
}

function monobase_archive_sub_taxonomy() {
	if ( is_tax() || is_category() || is_tag() ) {
		$term = get_queried_object();

		if ( $term instanceof WP_Term ) {
			$children = get_terms( [
				'taxonomy'   => $term->taxonomy,
				'parent'     => $term->term_id,
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			] );

			if ( ! is_wp_error( $children ) && ! empty( $children ) ) : ?>

                <div class="cards">
					<?php foreach ( $children as $child ) : ?>
                        <div class="card">
                            <h3 class="card-title"><?php echo esc_html( $child->name ); ?></h3>

							<?php $desc = term_description( $child->term_id, $child->taxonomy );
							if ( $desc ) {
								echo '<div class="card-description">' . wp_kses_post( monobase_get_first_paragraph( $desc ) ) . '</div>';
							}
							?>
                            <a href="<?php echo esc_url( get_term_link( $child ) ); ?>" class="card-link"
                               aria-label="<?php echo esc_attr( $child->name ); ?>">
                                <span class="mb-icon mb-icon-arrow-narrow-up" aria-hidden="true"></span>
                            </a>
                        </div>
					<?php endforeach; ?>
                </div>

			<?php endif;
		}
	}

}

function monobase_get_first_paragraph( $content ) {
	if ( empty( $content ) ) {
		return '';
	}

	if ( preg_match( '/<p>(.*?)<\/p>/is', $content, $matches ) ) {
		$content = $matches[1];
	}

	return $content;
}


function monobase_search_placeholder_text() {
	global $wp_query;
	$monobase_found = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;
	$monobase_ph    = __( 'Search…', 'monobase' );
	if ( ! empty( get_search_query() ) ) {
		$monobase_ph = sprintf( __( 'Find %d posts for %s', 'monobase' ), $monobase_found, get_search_query() );
	}
	echo esc_attr( $monobase_ph );
}

function monobase_side_menu_container_aria_label() {
	$menu = wp_get_nav_menu_object( 'side-menu' );
	if ( $menu ) {
		return esc_attr( $menu->name );
	}

	return esc_attr__( 'Sidebar navigation', 'monobase' );
}

// Helper: get first category ID for a post
function monobase_get_category_id( $post_id = null ): ?int {
	$post_id = $post_id ?: get_the_ID();
	$cats    = get_the_category( $post_id );

	return ! empty( $cats ) ? (int) $cats[0]->term_id : null;
}

// Helper: render <li> for a post (adds .sticky)
function monobase_render_post_li( WP_Post $p, $currentpage = false ): void {
	$is_date   = monobase_post_has_date();
	$is_sticky = is_sticky( $p->ID );
	$classes   = 'post-item' . ( $is_sticky ? ' sticky ' : '' ) . ( $is_date ? ' has-date ' : '' );
	$classes   .= $currentpage ? ' is-current' : '';
	$title     = get_the_title( $p );
	$excerpt   = get_the_excerpt( $p );
	$url       = get_permalink( $p );
	$date      = get_the_date( '', $p );
	?>
    <li class="<?php echo esc_attr( $classes ); ?>" role="listitem">
		<?php if ( $currentpage ) : ?>
            <a href="<?php echo esc_url( $url ); ?>" class="post-link" aria-label="<?php echo esc_attr( $title ); ?>"
               aria-current="page"></a>
		<?php else: ?>
            <a href="<?php echo esc_url( $url ); ?>" class="post-link"
               aria-label="<?php echo esc_attr( $title ); ?>"></a>
		<?php endif; ?>
        <div class="post-title"><?php echo esc_html( $title ); ?></div>
		<?php if ( $is_date ) : ?>
            <time class="post-time" datetime="<?php echo esc_attr( get_the_date( 'c', $p ) ); ?>">
				<?php echo esc_html( $date ); ?>
            </time>
		<?php endif; ?>
        <div class="post-description"><?php echo wp_kses_post( $excerpt ); ?></div>
        <span class="post-icon mb-icon mb-icon-chevron-right" aria-hidden="true"></span>
		<?php if ( $is_sticky ) : ?>
            <span class="post-badge" aria-label="<?php esc_attr_e( 'Sticky post', 'monobase' ); ?>">
				<span class="mb-icon mb-icon-pinned" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Sticky', 'monobase' ); ?></span>
			</span>
		<?php endif; ?>
    </li>
	<?php
}

// SINGLE: current post → sticky (same first category) → others (same first category)
function monobase_loop_single_sidebar(): void {
	$current_id = get_queried_object_id();
	$cat_id     = monobase_get_category_id( $current_id ); // твоя функція «перша категорія»

	$per_page = (int) get_option( 'posts_per_page' );
	$paged    = max( 1, (int) get_query_var( 'paged' ) );

	$appearance        = get_theme_mod( 'monobase_appearance', [] );
	$current_post_first = ! empty( $appearance['current_post_first'] );

	if ( ! $current_post_first ) {
		$current = get_post( $current_id );
		if ( $current instanceof WP_Post ) {
			monobase_render_post_li( $current, true );
		}
	}

	$sticky_ids = array_map( 'intval', (array) get_option( 'sticky_posts', [] ) );
	$sticky_ids = $current_post_first ? $sticky_ids : array_values( array_diff( $sticky_ids, [ $current_id ] ) );

	$S = 0;
	if ( $cat_id && $sticky_ids ) {
		$q_sticky = new WP_Query( [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => - 1,
			'post__in'            => $sticky_ids,
			'category__in'        => [ $cat_id ],
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
		] );

		$S = (int) $q_sticky->post_count;

		if ( $paged === 1 && $S ) {
			foreach ( $q_sticky->posts as $p ) {
				$is_current = $current_post_first && ( $p->ID === $current_id );
				monobase_render_post_li( $p, $is_current );
			}
		}

		wp_reset_postdata();
	}

	$current_offset = $current_post_first ? 0 : 1;
	$R1 = max( $per_page - ( $current_offset + $S ), 0 );

	$pp     = $per_page;
	$offset = 0;

	if ( $paged === 1 ) {
		$pp     = $R1;
		$offset = 0;
	} else {
		$pp     = $per_page;
		$offset = $R1 + ( $paged - 2 ) * $per_page;
	}

	$exclude = $current_post_first ? $sticky_ids : array_merge( [ $current_id ], $sticky_ids );

	$args_rest = [
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $pp,
		'offset'              => max( 0, (int) $offset ),
		'post__not_in'        => $exclude,
		'ignore_sticky_posts' => 1,
		'orderby'             => 'date',
		'order'               => 'DESC',
	];
	if ( $cat_id ) {
		$args_rest['category__in'] = [ $cat_id ];
	}

	if ( $pp > 0 || $paged > 1 ) {
		$q_rest = new WP_Query( $args_rest );
		foreach ( $q_rest->posts as $p ) {
			$is_current = $current_post_first && ( $p->ID === $current_id );
			monobase_render_post_li( $p, $is_current );
		}
		wp_reset_postdata();
	}
}

function monobase_category_with_descendants( int $cat_id ): array {
	$ids      = [ $cat_id ];
	$children = get_terms( [
		'taxonomy'   => 'category',
		'hide_empty' => false,
		'child_of'   => $cat_id,
		'fields'     => 'ids',
	] );
	if ( ! is_wp_error( $children ) && ! empty( $children ) ) {
		$ids = array_merge( $ids, $children );
	}

	return array_map( 'intval', array_unique( $ids ) );
}

function monobase_loop_archive_sidebar(): void {
	$sticky_ids = array_map( 'intval', (array) get_option( 'sticky_posts', [] ) );
	$per_page   = (int) get_option( 'posts_per_page' );
	$paged      = max( 1, (int) get_query_var( 'paged' ) );

	// Визначаємо тип архіву та параметри фільтрації
	$filter_args = [];

	if ( is_category() ) {
		$current_cat = (int) get_queried_object_id();
		$cat_ids     = monobase_category_with_descendants( $current_cat );
		if ( $cat_ids ) {
			$filter_args['category__in'] = $cat_ids;
		}
	} elseif ( is_tag() ) {
		$current_tag = (int) get_queried_object_id();
		if ( $current_tag ) {
			$filter_args['tag__in'] = [ $current_tag ];
		}
	} elseif ( is_author() ) {
		$current_author = (int) get_queried_object_id();
		if ( $current_author ) {
			$filter_args['author'] = $current_author;
		}
	}

	$sticky_in_archive = [];
	if ( ! empty( $filter_args ) && $sticky_ids ) {
		$q_in = new WP_Query( array_merge( [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => - 1,
			'post__in'            => $sticky_ids,
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
			'fields'              => 'ids',
		], $filter_args ) );
		$sticky_in_archive = array_map( 'intval', (array) $q_in->posts );
		wp_reset_postdata();
	}

	$S  = count( $sticky_in_archive );
	$R1 = max( $per_page - $S, 0 );

	if ( $S && $paged === 1 ) {
		$q_sticky = new WP_Query( [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => - 1,
			'post__in'            => $sticky_in_archive,
			'orderby'             => 'post__in',
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
		] );
		foreach ( $q_sticky->posts as $p ) {
			monobase_render_post_li( $p );
		}
		wp_reset_postdata();
	}

	$pp     = $per_page;
	$offset = 0;

	if ( $paged === 1 ) {
		$pp     = $R1;
		$offset = 0;
	} else {
		$pp     = $per_page;
		$offset = $R1 + ( $paged - 2 ) * $per_page;
	}

	if ( $pp > 0 || $paged > 1 ) {
		$q = new WP_Query( array_merge( [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $pp,
			'offset'              => max( 0, $offset ),
			'post__not_in'        => $sticky_in_archive,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'ignore_sticky_posts' => 1,
		], $filter_args ) );

		foreach ( $q->posts as $p ) {
			monobase_render_post_li( $p );
		}
		wp_reset_postdata();
	}
}

function monobase_loop_home_sidebar(): void {
	$sticky_ids = array_map( 'intval', (array) get_option( 'sticky_posts', [] ) );
	$per_page   = (int) get_option( 'posts_per_page' );
	$paged      = max( 1, (int) get_query_var( 'paged' ) );

	// Скільки реально є sticky на сайті
	$S  = count( $sticky_ids );
	$R1 = max( $per_page - $S, 0 ); // скільки звичайних постів вивести на 1-й сторінці поряд зі sticky

	// 1) Sticky — лише на першій сторінці
	if ( $S && $paged === 1 ) {
		$q_sticky = new WP_Query( [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => - 1,
			'post__in'            => $sticky_ids,
			'orderby'             => 'post__in', // зберегти порядок sticky
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => true,
		] );
		foreach ( $q_sticky->posts as $p ) {
			monobase_render_post_li( $p );
		}
		wp_reset_postdata();
	}

	// 2) Звичайні пости (без sticky), з правильним pp та offset
	$pp     = $per_page;
	$offset = 0;

	if ( $paged === 1 ) {
		$pp     = $R1;              // лише те, що “поміщається” поряд зі sticky
		$offset = 0;
	} else {
		$pp     = $per_page;        // повна сторінка
		$offset = $R1 + ( $paged - 2 ) * $per_page; // пропускаємо те, що вже показали на стор.1 та міжсторінкові блоки
	}

	// Якщо на 1-й сторінці sticky повністю зайняли ліміт (R1=0), звичайні підуть з 2-ї сторінки
	if ( $pp > 0 || $paged > 1 ) {
		$q = new WP_Query( [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $pp,
			'offset'              => max( 0, $offset ),
			'post__not_in'        => $sticky_ids,
			'ignore_sticky_posts' => 1,
			'orderby'             => 'date',
			'order'               => 'DESC',
		] );
		foreach ( $q->posts as $p ) {
			monobase_render_post_li( $p );
		}
		wp_reset_postdata();
	}
}


function monobase_post_author_link() {
	$author_id   = get_the_author_meta( 'ID' );
	$author_name = get_the_author_meta( 'display_name' );
	$user_url    = get_the_author_meta( 'user_url', $author_id );
	echo '<a href="' . esc_url( $user_url ) . '" target="_blank">' . esc_html( $author_name ) . '</a>';
}


function monobase_post_modification(): void {
	$published = get_the_time( 'U' );
	$modified  = get_the_modified_time( 'U' );

    $appearance        = get_theme_mod( 'monobase_appearance', [] );
    $only_publish = ! empty( $appearance['post_publish'] );


	if ( $published !== $modified && empty($only_publish) ) {
		echo '<div class="card-title">' . esc_html__( 'Modification', 'monobase' ) . '</div>';
		echo '<div class="card-content"><time>' . esc_html( get_the_modified_date( 'j/n/Y' ) ) . '</time></div>';
	} else {
		echo '<div class="card-title">' . esc_html__( 'Published', 'monobase' ) . '</div>';
		echo '<div class="card-content"><time>' . esc_html( get_the_date( 'j/n/Y' ) ) . '</time></div>';
	}
}


function monobase_post_tags(): void {
	$tags = get_the_tags();

	if ( ! $tags ) {
		return;
	}

	$tag_links = [];
	foreach ( $tags as $tag ) {
		$tag_links[] = sprintf(
			'<a href="%s">%s</a>',
			esc_url( get_tag_link( $tag->term_id ) ),
			esc_html( $tag->name )
		);
	}

	echo '<div class="footer-card is-full">';
	echo '  <div class="card-icon"><span class="mb-icon mb-icon-hash" aria-hidden="true"></span></div>';
	echo '  <div class="card-title">' . esc_html__( 'Tags', 'monobase' ) . '</div>';
	echo '  <div class="card-content">' . wp_kses_post( implode( ', ', $tag_links ) ) . '</div>';
	echo '</div>';
}


function monobase_homepage_menu(): void {
	$locations  = get_nav_menu_locations();
	$menu_id    = $locations['homepage'] ?? null;
	$menu_items = $menu_id ? wp_get_nav_menu_items( $menu_id ) : [];

	if ( empty( $menu_items ) ) {
		return;
	}

	echo '<div class="cards">';

	foreach ( $menu_items as $item ) {


		$check_user = apply_filters( 'monobase_menu_item_check_user', false, $item->ID );

		if ( $check_user ) {
			continue;
		}

		$title = esc_html( $item->title );
		$url   = esc_url( $item->url );
		$desc  = $item->description ? esc_html( $item->description ) : '';

		echo '<div class="card">';

		$icon = apply_filters( 'monobase_menu_item_icon', '', $item->ID, $item->title );

		if ( ! empty( $icon ) ) {
			echo '<div class="card-icon">' . wp_kses_post( $icon ) . '</div>';
		}

		echo '<h3 class="card-title">' . esc_html( $title ) . '</h3>';

		if ( $desc ) {
			echo '<div class="card-description">' . wp_kses_post( $desc ) . '</div>';
		}

		echo '<a href="' . $url . '" class="card-link" aria-label="' . esc_attr( $title ) . '"><span class="mb-icon mb-icon-arrow-narrow-up" aria-hidden="true"></span></a>';

		echo '</div>';
	}

	echo '</div>';
}

function monobase_site_logo() {
	$appearance   = get_theme_mod( 'monobase_appearance' );
	$dark_logo_id = $appearance['dark_logo'] ?? null;
	$dark_logo    = $dark_logo_id ? wp_get_attachment_image_src( $dark_logo_id, 'full' )[0] : '';

	if ( has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		$logo    = wp_get_attachment_image_src( $logo_id, 'full' )[0];
		?>

        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo-light">
			<?php if ( $dark_logo ) : ?>
                <img src="<?php echo esc_url( $dark_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"
                     class="logo-dark">
			<?php endif; ?>
        </a>

		<?php
	}
}

function monobase_post_category() {
	$categories = get_the_category( get_the_ID() );
	if ( ! empty( $categories ) ) {
		$first_cat = $categories[0]; // WP_Term object
		echo '<a href="' . esc_url( get_category_link( $first_cat->term_id ) ) . '" class="category-link">'
		     . esc_html( $first_cat->name ) . '</a>';
	}
}