<?php
/**
 * The template for displaying archive pages
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

            <section class="section-box" id="primary">
                <header class="entry-header">
					<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                </header>
				<?php monobase_archive_summary(); ?>
				<?php monobase_archive_sub_taxonomy(); ?>
				<?php monobase_archive_description(); ?>
            </section>

        </main><!-- #main -->
    </div>

<?php
get_footer();
