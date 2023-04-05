<?php
/**
 * Plugin Name:     Turbo Drive
 * Plugin URI:      https://wordpress.org/plugins/td-turbo-drive
 * Description:     Integrate Hotwired Turbo with WordPress, no page reload, no jQuery, no bullshit.
 * Author:          Romain Herault
 * Author URI:      https://rherault.dev
 * Text Domain:     turbo-drive
 * Domain Path:     /languages
 * Version:         0.2.0
 *
 * @package         Turbo_Drive
 */

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('turbo-drive', plugins_url('/dist/main.js', __FILE__));
}, 10);

add_action('admin_head', function () {
    echo '<meta name="turbo-visit-control" content="reload">';
}, 10);

add_filter('script_loader_tag', function ($script_tag) {
    if (is_admin()) {
        return $script_tag;
    }
    global $current_screen;
    if ($current_screen instanceof \WP_Screen && $current_screen->is_block_editor()) {
        return $script_tag;
    }

    return str_replace(' src', ' data-turbo-track="reload" src', $script_tag);
}, 10, 1);

add_filter('style_loader_tag', function ($style_tag) {
    if (is_admin()) {
        return $style_tag;
    }
    global $current_screen;
    if ($current_screen instanceof \WP_Screen && $current_screen->is_block_editor()) {
        return $style_tag;
    }

    return str_replace(' href', ' data-turbo-track="reload" href', $style_tag);
}, 10, 1);
