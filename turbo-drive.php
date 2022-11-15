<?php
/**
 * Plugin Name:     Turbo Drive
 * Plugin URI:      https://wordpress.org/plugins/turbo-drive
 * Description:     Integrate Hotwired Turbo with WordPress, no page reload, no jQuery, no bullshit.
 * Author:          Romain Herault
 * Author URI:      https://rherault.dev
 * Text Domain:     turbo-drive
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Turbo_Drive
 */

add_action('wp_enqueue_scripts', function() {
	wp_enqueue_script('turbo-drive', plugins_url('/dist/main.js', __FILE__));
});

add_action('admin_head', function() {
	echo '<meta name="turbo-visit-control" content="reload">';
});
