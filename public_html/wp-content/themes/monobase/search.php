<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Monobase
 */

get_header();
?>
    <div class="site-box">

		<?php get_sidebar( 'menus' ); ?>

        <main class="main-box">
	        <?php get_header( 'main' ); ?>
			<?php get_template_part( 'template-parts/content', 'search' ); ?>
        </main><!-- #main -->
    </div>
<?php
get_footer();
