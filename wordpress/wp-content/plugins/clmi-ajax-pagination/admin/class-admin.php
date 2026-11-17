<?php
if (!defined('ABSPATH')) {
    exit;
}

class CLMI_Admin {

    public function __construct() {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_init', [$this, 'settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function menu() {
        add_menu_page(
            esc_html__('AJAX Pagination', 'clmi-ajax-pagination'),
            esc_html__('AJAX Pagination', 'clmi-ajax-pagination'),
            'manage_options',
            'clmi-settings',
            [$this, 'settings_page'],
            'dashicons-update',
            25
        );
    }

    public function settings() {

        register_setting('clmi_settings_group', 'clmi_settings', [
            'sanitize_callback' => [$this, 'sanitize']
        ]);

        add_settings_section('clmi_main_section', '', null, 'clmi-settings');

        add_settings_field(
            'pagination_type',
            esc_html__('Pagination Type', 'clmi-ajax-pagination'),
            [$this, 'pagination_type_field'],
            'clmi-settings',
            'clmi_main_section'
        );

        add_settings_field(
            'post_type',
            esc_html__('Post Type', 'clmi-ajax-pagination'),
            [$this, 'post_type_field'],
            'clmi-settings',
            'clmi_main_section'
        );

        add_settings_field(
            'alignment',
            esc_html__('Alignment', 'clmi-ajax-pagination'),
            [$this, 'alignment_field'],
            'clmi-settings',
            'clmi_main_section'
        );

        add_settings_field(
            'custom_class',
            esc_html__('Custom Class', 'clmi-ajax-pagination'),
            [$this, 'class_field'],
            'clmi-settings',
            'clmi_main_section'
        );

        add_settings_field(
            'button_color',
            esc_html__('Button Color', 'clmi-ajax-pagination'),
            [$this, 'button_color_field'],
            'clmi-settings',
            'clmi_main_section'
        );

        add_settings_field(
            'text_color',
            esc_html__('Text Color', 'clmi-ajax-pagination'),
            [$this, 'text_color_field'],
            'clmi-settings',
            'clmi_main_section'
        );

        add_settings_field(
            'loader_image',
            esc_html__('Loader Image', 'clmi-ajax-pagination'),
            [$this, 'loader_field'],
            'clmi-settings',
            'clmi_main_section'
        );

        add_settings_field(
            'button_padding',
            esc_html__('Button Padding', 'clmi-ajax-pagination'),
            [$this, 'padding_field'],
            'clmi-settings',
            'clmi_main_section'
        );
    }

    public function pagination_type_field() {
        $opt = get_option('clmi_settings');
        $val = $opt['pagination_type'] ?? 'load_more';
        ?>
        <select name="clmi_settings[pagination_type]">
            <option value="load_more" <?php selected($val, 'load_more'); ?>><?php esc_html_e('Load More', 'clmi-ajax-pagination'); ?></option>
            <option value="numbers" <?php selected($val, 'numbers'); ?>><?php esc_html_e('Numbers', 'clmi-ajax-pagination'); ?></option>
            <option value="infinite" <?php selected($val, 'infinite'); ?>><?php esc_html_e('Infinite', 'clmi-ajax-pagination'); ?></option>
        </select>
        <?php
    }

    public function post_type_field() {
        $opt = get_option('clmi_settings');
        $val = $opt['post_type'] ?? 'post';

        $post_types = get_post_types(['public' => true], 'objects');

        echo '<select name="clmi_settings[post_type]">';
        foreach ($post_types as $pt) {
            echo '<option value="' . esc_attr($pt->name) . '" ' . selected($val, $pt->name, false) . '>' . esc_html($pt->label) . '</option>';
        }
        echo '</select>';
    }

    public function alignment_field() {
        $opt = get_option('clmi_settings');
        $val = $opt['alignment'] ?? 'center';
        ?>
        <select name="clmi_settings[alignment]">
            <option value="left" <?php selected($val, 'left'); ?>><?php esc_html_e('Left', 'clmi-ajax-pagination'); ?></option>
            <option value="center" <?php selected($val, 'center'); ?>><?php esc_html_e('Center', 'clmi-ajax-pagination'); ?></option>
            <option value="right" <?php selected($val, 'right'); ?>><?php esc_html_e('Right', 'clmi-ajax-pagination'); ?></option>
        </select>
        <?php
    }

    public function class_field() {
        $opt = get_option('clmi_settings');
        $val = $opt['custom_class'] ?? '';
        ?>
        <input type="text" name="clmi_settings[custom_class]" value="<?php echo esc_attr($val); ?>">
        <?php
    }

    public function button_color_field() {
        $opt = get_option('clmi_settings');
        $val = $opt['button_color'] ?? '#000000';
        ?>
        <input type="color" name="clmi_settings[button_color]" value="<?php echo esc_attr($val); ?>">
        <?php
    }

    public function text_color_field() {
        $opt = get_option('clmi_settings');
        $val = $opt['text_color'] ?? '#ffffff';
        ?>
        <input type="color" name="clmi_settings[text_color]" value="<?php echo esc_attr($val); ?>">
        <?php
    }

    public function settings_page() {

        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('AJAX Pagination Settings', 'clmi-ajax-pagination'); ?></h1>

            <form method="post" action="options.php">
                <?php
                settings_fields('clmi_settings_group');
                do_settings_sections('clmi-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function loader_field() {

        $options = get_option('clmi_settings');
        $value = $options['loader_image'] ?? '';
        ?>

        <div class="clmi-loader-wrap">

            <input type="hidden" 
                name="clmi_settings[loader_image]" 
                id="clmi_loader_image"
                value="<?php echo esc_attr($value); ?>" />

            <div class="clmi-preview" style="margin-bottom:10px;">
                <?php if ($value): ?>
                    <img src="<?php echo esc_url($value); ?>" style="max-width:60px;">
                <?php endif; ?>
            </div>

            <button type="button" class="button clmi-upload-btn">
                <?php esc_html_e('Upload Loader', 'clmi-ajax-pagination'); ?>
            </button>

            <button type="button" class="button clmi-remove-btn" <?php echo empty($value) ? 'style="display:none;"' : ''; ?>>
                <?php esc_html_e('Remove', 'clmi-ajax-pagination'); ?>
            </button>

        </div>

        <?php
    }

    public function padding_field() {
        $opt = get_option('clmi_settings');
        $val = $opt['button_padding'] ?? '10px 20px';
        ?>
        <input type="text"
            name="clmi_settings[button_padding]"
            value="<?php echo esc_attr($val); ?>"
            placeholder="10px 20px">
        <p class="description">
            <?php esc_html_e('Example: 10px 20px (top-bottom left-right)', 'clmi-ajax-pagination'); ?>
        </p>
        <?php
    }

    public function enqueue_admin_assets($hook) {

        if ($hook !== 'toplevel_page_clmi-settings') {
            return;
        }

        wp_enqueue_media();

        wp_enqueue_script(
            'clmi-admin-js',
            CLMI_PLUGIN_URL . 'admin/js/admin.js',
            ['jquery'],
            CLMI_VERSION,
            true
        );
    }

    public function sanitize($input) {

        $allowed_types = ['load_more', 'numbers', 'infinite'];
        $allowed_alignment = ['left', 'center', 'right'];

        $post_type = sanitize_text_field($input['post_type'] ?? '');
        $post_types = get_post_types(['public' => true]);

        if (!in_array($post_type, $post_types, true)) {
            $post_type = 'post';
        }

        return [
            'pagination_type' => in_array($input['pagination_type'] ?? '', $allowed_types, true)
                ? $input['pagination_type']
                : 'load_more',

            'post_type'       => $post_type,

            'alignment'       => in_array($input['alignment'] ?? '', $allowed_alignment, true)
                ? $input['alignment']
                : 'center',

            'custom_class'    => sanitize_text_field($input['custom_class'] ?? ''),
            'button_color'    => sanitize_hex_color($input['button_color'] ?? ''),
            'text_color'      => sanitize_hex_color($input['text_color'] ?? ''),
            'loader_image'    => esc_url_raw($input['loader_image'] ?? ''),
            'button_padding'  => sanitize_text_field($input['button_padding'] ?? '10px 20px'),
        ];
    }
}