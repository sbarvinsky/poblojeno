<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Monobase
 */

get_header();
?>

    <div class="site-box">

		<?php get_sidebar( 'menus' ); ?>
		<?php get_sidebar( 'posts' ); ?>

        <main class="main-box">
			<?php get_header( 'main' ); ?>
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="mb-icon mb-icon-chevron-right mb-icon-rotate-180"></span><span class="nav-subtitle has-tooltip on-top" data-tooltip="%title">' . esc_html__( 'Previous', 'monobase' ) . '</span>',
						'next_text' => '<span class="nav-subtitle has-tooltip on-top" data-tooltip="%title">' . esc_html__( 'Next', 'monobase' ) . '</span><span class="mb-icon mb-icon-chevron-right"></span>',
					)
				);

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

        </main><!-- #main -->
    </div>

<?php
get_footer();
