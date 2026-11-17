<?php
/**
 * Plugin Name: Unadorned Announcement Bar
 */
add_action('admin_menu', function () {
    add_menu_page(
        'Announcement Bar',
        'Announcement Bar',
        'manage_options',
        'uab-settings',
        'uab_render_admin_page',
        'dashicons-megaphone'
    );
});

function uab_render_admin_page() {
    echo '<div id="uab-admin-root"></div>';
}
add_action('admin_enqueue_scripts', function ($hook) {

    // Load only on your plugin page
    if ($hook !== 'toplevel_page_uab-settings') {
        return;
    }

    $asset = include plugin_dir_path(__FILE__) . 'build/index.asset.php';

        wp_enqueue_script(
            'uab-admin-script',
            plugin_dir_url(__FILE__) . 'build/index.js',
            $asset['dependencies'], 
            $asset['version'],
            true
        );

    wp_enqueue_style('wp-components');
});

add_action('rest_api_init', function () {

    register_setting('uab_settings_group', 'uab_settings', [
            'type' => 'object',
            'show_in_rest' => [
                'schema' => [
                    'type' => 'object',
                    'properties' => [
                        'text' => ['type' => 'string'],
                        'enabled' => ['type' => 'boolean'],
                        'bgColor' => ['type' => 'string'],
                        'textColor' => ['type' => 'string'],
                        'position' => ['type' => 'string'],
                    ],
                ],
            ],
            'default' => [
                'text' => '',
                'enabled' => false,
                'bgColor' => '#000000',
                'textColor' => '#ffffff',
                'position' => 'bottom',
            ],
        ]);
});

add_action('wp_footer', function () {

    $settings = get_option('uab_settings');

    if (empty($settings['enabled']) || empty($settings['text'])) {
        return;
    }

    echo '<div style="
        position: fixed;
        bottom: 0;
        width: 100%;
        background: #000;
        color: #fff;
        text-align: center;
        padding: 10px;
        z-index: 9999;
    ">
        ' . esc_html($settings['text']) . '
    </div>';
});