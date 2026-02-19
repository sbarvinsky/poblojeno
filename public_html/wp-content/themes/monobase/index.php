<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
            <div id="primary">
				<?php
				if ( is_home() && is_front_page() && monobase_check_home_page_teplate_include() ) {
					get_template_part( 'template-parts/content', 'homepage' );
				} elseif ( have_posts() ) {
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'index' );

					endwhile;

					the_posts_pagination( [
						'mid_size'           => 1,
						'end_size'           => 0,
						'prev_text'          => '<span class="mb-icon mb-icon-chevron-right mb-icon-rotate-180" aria-hidden="true"></span><span class="screen-reader-text">' . esc_html__( 'Previous', 'monobase' ) . '</span>',
						'next_text'          => '<span class="mb-icon mb-icon-chevron-right" aria-hidden="true"></span><span class="screen-reader-text">' . esc_html__( 'Next', 'monobase' ) . '</span>',
						'type'               => 'list',
						'screen_reader_text' => ' ',
					] );

				} else {

					get_template_part( 'template-parts/content', 'none' );

				}
				?>
            </div>
        </main><!-- #main -->
    </div>
<?php
get_footer();
