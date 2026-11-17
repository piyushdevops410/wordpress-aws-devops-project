<?php
/**
 * Plugin Name: Custom Gutenberg Block Native
 */

if (!defined('ABSPATH')) exit;

add_action('init', function () {

    wp_register_script(
        'custom-block-js',
        plugins_url('block.js', __FILE__),
        [
            'wp-blocks',
            'wp-element',
            'wp-editor',
            'wp-components',
            'wp-i18n'
        ],
        filemtime(plugin_dir_path(__FILE__) . 'block.js')
    );

    wp_register_style(
        'custom-block-editor-css',
        plugins_url('editor.css', __FILE__)
    );

    wp_register_style(
        'custom-block-css',
        plugins_url('style.css', __FILE__)
    );

    register_block_type('custom/block-example', [
        'editor_script' => 'custom-block-js',
        'editor_style'  => 'custom-block-editor-css',
        'style'         => 'custom-block-css'
    ]);
});
