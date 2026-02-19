<?php
/**
 * Header with action buttons
 *
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Monobase
 */

?>

<section class="actions-box">
    <div class="actions-meta">

        <?php if ( !is_page() && !is_search() ) : ?>
        <div class="action-toggle">
            <button class="toggle-posts button is-ghost is-action switcher" aria-expanded="false"
                    aria-controls="sidebar-posts" aria-label="<?php esc_attr_e( 'Posts', 'monobase' ); ?>">
                <span class="mb-icon mb-icon-arrow-bar-to-left" aria-hidden="true"></span>
                <span class="toggle-posts-text"><?php esc_html_e( 'Posts', 'monobase' ); ?></span>
            </button>
        </div>
        <?php endif; ?>

		<?php if ( is_single() ) : ?>
            <div class="article-category">
                <span class="mb-icon mb-icon-circle" aria-hidden="true"></span>
				<?php monobase_post_category(); ?>
            </div>
		<?php elseif ( !is_search() ): ?>
            <div class="search-box">
				<?php get_search_form(); ?>
            </div>
		<?php endif; ?>

        <div class="action-group">
            <button id="copy-url" class="button is-ghost is-icon has-tooltip on-right"
                    data-tooltip="<?php esc_attr_e( 'Copy URL', 'monobase' ); ?>"
                    data-toggle-tooltip="<?php esc_attr_e( 'Copied', 'monobase' ); ?>">
                <span class="mb-icon mb-icon-link" aria-hidden="true"></span>
                <span class="mb-icon mb-icon-check" hidden aria-hidden="true"></span>
            </button>

			<?php do_action( 'monobase_header_actions' ); ?>

            <button id="theme-mode" class="button is-ghost is-icon has-tooltip on-left" aria-label="<?php esc_attr_e( 'Dark Mode', 'monobase' ); ?>"
                    data-tooltip="<?php esc_attr_e( 'Dark Mode', 'monobase' ); ?>"
                    data-toggle-tooltip="<?php esc_attr_e( 'Light Mode', 'monobase' ); ?>">
                <span class="mb-icon mb-icon-circle-half-2" aria-hidden="true"></span>
            </button>

        </div>
    </div>
</section>
