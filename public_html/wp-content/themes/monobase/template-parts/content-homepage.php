<?php
/**
 * Template part for displaying Homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Monobase
 */


$monobase_home_page = get_theme_mod( 'monobase_home', [] );
?>

<?php get_header( 'main' ); ?>


<section class="section-box">
	<?php if ( ! empty( $monobase_home_page['title'] ) ) : ?>
        <header class="entry-header">
            <h1 class="page-title"><?php echo esc_html( $monobase_home_page['title'] ); ?></h1>
        </header>
	<?php else: ?>
        <h1 class="screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
	<?php endif; ?>
	<?php if ( ! empty( $monobase_home_page['excerpt'] ) ) : ?>
        <div class="entry-summary"><?php echo esc_html( $monobase_home_page['excerpt'] ); ?></div>
	<?php endif; ?>

    <?php monobase_homepage_menu(); ?>

	<?php if ( ! empty( $monobase_home_page['content'] ) ) : ?>
        <div class="entry-content"><?php echo wp_kses_post( wpautop( $monobase_home_page['content'] ) ); ?></div>
	<?php endif; ?>

</section>



