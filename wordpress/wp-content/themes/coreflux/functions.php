<?php
if (!defined('ABSPATH')) exit;

function coreflux_setup() {
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
}
add_action('after_setup_theme', 'coreflux_setup');

function coreflux_register_pattern_category() {
    register_block_pattern_category(
        'coreflux',
        ['label' => __('CoreFlux Patterns', 'coreflux')]
    );
}
add_action('init', 'coreflux_register_pattern_category');

function coreflux_block_styles() {

    // Outline Button Style
    register_block_style(
        'core/button',
        [
            'name'  => 'outline',
            'label' => __('Outline Button', 'coreflux'),
        ]
    );

    // Card Style for Group
    register_block_style(
        'core/group',
        [
            'name'  => 'card',
            'label' => __('Card', 'coreflux'),
        ]
    );

}
add_action('init', 'coreflux_block_styles');

function coreflux_enqueue_assets() {
    wp_enqueue_style(
        'coreflux-style',
        get_template_directory_uri() . '/assets/css/style.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'coreflux_enqueue_assets');

function coreflux_block_variations() {

    wp_register_script(
        'coreflux-block-variations',
        get_template_directory_uri() . '/assets/js/block-variations.js',
        ['wp-blocks', 'wp-dom-ready', 'wp-edit-post'],
        wp_get_theme()->get('Version'),
        true
    );

    wp_enqueue_script('coreflux-block-variations');
}
add_action('enqueue_block_editor_assets', 'coreflux_block_variations');