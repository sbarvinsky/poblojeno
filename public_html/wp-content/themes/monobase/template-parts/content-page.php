<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Monobase
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>

    <header class="entry-header" id="primary">
	    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	    <?php if(has_excerpt()) : ?>
            <div class="entry-summary">
			    <?php the_excerpt(); ?>
            </div>
	    <?php endif; ?>
    </header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages( [
			'before'           => '<nav class="page-links" aria-label="'.esc_attr__('Page links','monobase').'">',
			'after'            => '</nav>',
			'link_before'      => '<span class="page-number">',  // UI only
			'link_after'       => '</span>',
			'next_or_number'   => 'number',
			'separator'        => '',
		] );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'monobase' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
