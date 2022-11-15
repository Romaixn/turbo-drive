<?php
/**
 * Plugin Name:     Turbo WP
 * Plugin URI:      https://rherault.fr
 * Description:     Integrate Hotwired Turbo with WordPress, no page reload, no jQuery, no bullshit.
 * Author:          Romain Herault
 * Author URI:      https://rherault.fr
 * Text Domain:     wp-turbo
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         WP_Turbo
 */

add_action('wp_enqueue_scripts', function() {
	wp_enqueue_script('wp-turbo', plugins_url('/dist/main.js', __FILE__));
});

add_action('admin_head', function() {
	echo '<meta name="turbo-visit-control" content="reload">';
});
