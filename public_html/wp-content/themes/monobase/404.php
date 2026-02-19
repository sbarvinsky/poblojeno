<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Monobase
 */

get_header();
?>

    <div class="site-box">

		<?php get_sidebar( 'menus' ); ?>

        <main class="main-box">
			<?php get_header( 'main' ); ?>

            <section class="error-404 not-found page-content" id="primary">

                <header class="entry-header" id="primary">
                    <h1 class="entry-title">
                        > <?php esc_html_e( 'Error 404: Resource not found', 'monobase' ); ?>
                    </h1>
                    <p class="entry-summary"><?php esc_html_e( 'Requested URL does not exist.', 'monobase' ); ?></p>
                </header><!-- .page-header -->

                <div class="error404-content">

                    <div class=" entry-content">
                         <pre><code>
if (page == NULL) {
    printf("<?php esc_html_e( 'Not found', 'monobase' ); ?> (╯°□°)╯︵ ┻━┻\n");
    exit(1);
}
 </code></pre>
                        <a href="<?php echo esc_url( home_url() ); ?>"
                           class="button"><?php esc_html_e( '// Go home!', 'monobase' ); ?></a>
                    </div>

                </div>

            </section>

        </main><!-- #main -->
    </div>
<?php
get_footer();
