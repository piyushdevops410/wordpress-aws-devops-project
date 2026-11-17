<?php
/**
 * Plugin Name: CLMI ajax pagination
 * Description: Powerful AJAX pagination plugin with Load More, numbered pagination, and infinite scroll. Display posts anywhere using the shortcode [clmi_posts] with no page refresh.
 * Version: 2.1
 * Author: Piyush Koshti
 * Author URI: https://profiles.wordpress.org/piyushkoshti/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: clmi-ajax-pagination
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Tested up to: 6.9
 */

if (!defined('ABSPATH')) {
    exit;
}

define('CLMI_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CLMI_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CLMI_VERSION', '2.1');

// Load required files safely
$clmi_files = [
    CLMI_PLUGIN_PATH . 'admin/class-admin.php',
    CLMI_PLUGIN_PATH . 'includes/class-shortcode.php',
    CLMI_PLUGIN_PATH . 'includes/class-ajax.php',
];

foreach ($clmi_files as $file) {
    if (file_exists($file)) {
        require_once $file;
    }
}

// Initialize plugin
function clmi_init_plugin() {

    if (class_exists('CLMI_Admin')) {
        new CLMI_Admin();
    }

    if (class_exists('CLMI_Shortcode')) {
        new CLMI_Shortcode();
    }

    if (class_exists('CLMI_Ajax')) {
        new CLMI_Ajax();
    }
}
add_action('plugins_loaded', 'clmi_init_plugin');

// Enqueue frontend assets
function clmi_enqueue_assets() {
    wp_enqueue_style(
        'clmi-css',
        CLMI_PLUGIN_URL . 'public/css/style.css',
        [],
        CLMI_VERSION
    );
}
add_action('wp_enqueue_scripts', 'clmi_enqueue_assets');