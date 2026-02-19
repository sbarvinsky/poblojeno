<?php
/**
 * Search form
 *
 * @package Monobase
 */

?>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="search-form" role="search">
    <span class="mb-icon mb-icon-list-search search-icon" aria-hidden="true"></span>

    <label class="screen-reader-text" for="q"><?php esc_html_e( 'Search for:', 'monobase' ); ?></label>
    <input id="q" type="search" name="s" class="search-field"
           placeholder="<?php monobase_search_placeholder_text(); ?>"
           autocomplete="off">

    <button type="submit" class="search-button has-tooltip on-left"
            aria-label="<?php esc_attr_e( 'Submit search', 'monobase' ); ?>"
            data-tooltip="<?php esc_attr_e( 'Search', 'monobase' ); ?>">
        <span class="mb-icon mb-icon-arrow-back search-icon" aria-hidden="true"></span>
    </button>
</form>
