<?php
/**
 * Plugin Name: CTA Advance Custom Block
 * Description: Gutenberg Call To Action Block with styling options.
 * Version: 1.0
 * Author: Piyush Koshti
 * Author URI: https://profiles.wordpress.org/piyushkoshti/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cta-advance-custom-block
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Tested up to: 6.9
 */

if (!defined('ABSPATH')) exit;

function cta_block_register() {

    wp_register_script(
        'cta-block-editor',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components'),
        filemtime(plugin_dir_path(__FILE__) . 'block.js'), true 
    );

    wp_register_style(
        'cta-block-style',
        plugins_url('style.css', __FILE__),
        array(),
        filemtime(plugin_dir_path(__FILE__) . 'style.css')
    );

    register_block_type('custom/cta-block', array(
        'editor_script' => 'cta-block-editor',
        'style' => 'cta-block-style',
        'render_callback' => function ($attributes) {
            ob_start();
            include plugin_dir_path(__FILE__) . 'render.php';
            return ob_get_clean();
        },
        'attributes' => array(

            'title' => array('type' => 'string'),
            'content' => array('type' => 'string'),
            'buttonText' => array('type' => 'string', 'default' => 'Click Here'),
            'buttonURL' => array('type' => 'string'),

            'bgColor' => array('type' => 'string', 'default' => '#f5f5f5'),
            'textColor' => array('type' => 'string', 'default' => '#000000'),
            'buttonColor' => array('type' => 'string', 'default' => '#0073aa'),
            'alignment' => array('type' => 'string', 'default' => 'center'),

            // NEW DESIGN OPTIONS
            'fullWidth' => array('type' => 'boolean', 'default' => false),
            'maxWidth' => array('type' => 'string', 'default' => '1200px'),
            'padding' => array('type' => 'string', 'default' => '30px'),
            'borderRadius' => array('type' => 'string', 'default' => '8px'),
            'boxShadow' => array('type' => 'string', 'default' => 'none'),

        )
    ));
}
add_action('init', 'cta_block_register');