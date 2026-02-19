<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Monobase
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'section-box' ); ?>>

	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php if ( has_excerpt() ) : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		<?php endif; ?>
	</header>

	<?php the_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'monobase' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages( [
			'before'         => '<nav class="page-links" aria-label="' . esc_attr__( 'Page links', 'monobase' ) . '">',
			'after'          => '</nav>',
			'link_before'    => '<span class="page-number">',  // UI only
			'link_after'     => '</span>',
			'next_or_number' => 'number',
			'separator'      => '',
		] );
		?>
	</div><!-- .entry-content -->


	<footer class="entry-footer">

		<div class="footer-card">
			<div class="card-icon">
				<span class="icon icon-user-group" aria-hidden="true"></span>
			</div>
			<div class="card-title"><?php esc_html_e( 'Author', 'monobase' ); ?></div>
			<div class="card-content">
				<?php monobase_post_author_link(); ?>
			</div>
		</div>
		<div class="footer-card">
			<div class="card-icon">
				<span class="icon icon-clock" aria-hidden="true"></span>
			</div>
			<?php monobase_post_modification(); ?>
		</div>

		<?php monobase_post_tags()?>

	</footer>

</article><!-- #post-<?php the_ID(); ?> -->
