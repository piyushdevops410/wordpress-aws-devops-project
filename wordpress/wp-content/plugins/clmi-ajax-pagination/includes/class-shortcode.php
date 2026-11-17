<?php
if (!defined('ABSPATH')) {
    exit;
}

class CLMI_Shortcode {

    public function __construct() {
        add_shortcode('clmi_posts', [$this, 'render']);
    }

    /**
     * Enqueue frontend assets ONLY when shortcode is used
     */
    private function enqueue_assets() {

        wp_enqueue_style(
            'clmi-css',
            CLMI_PLUGIN_URL . 'public/css/style.css',
            [],
            CLMI_VERSION
        );

        wp_enqueue_script(
            'clmi-js',
            CLMI_PLUGIN_URL . 'public/js/ajax.js',
            ['jquery'],
            CLMI_VERSION,
            true
        );

        wp_localize_script('clmi-js', 'clmi_ajax', [
            'ajax_url' => esc_url(admin_url('admin-ajax.php')),
            'nonce'    => wp_create_nonce('clmi_nonce')
        ]);
    }

    /**
     * Shortcode Render
     */
        public function render() {

            $settings = get_option('clmi_settings');

            $post_type  = $settings['post_type'] ?? 'post';
            $pagination = $settings['pagination_type'] ?? 'load_more';
            $alignment  = $settings['alignment'] ?? 'center';
            $loader     = $settings['loader_image'] ?? '';
            $padding    = $settings['button_padding'] ?? '10px 20px';

            $btn_color  = $settings['button_color'] ?? '#000000';
            $text_color = $settings['text_color'] ?? '#ffffff';

            //  IMPORTANT: Load assets properly
            $this->enqueue_assets();

            //  Dynamic CSS
            $custom_css = "
            #clmi-container .clmi-pagination button,
            #clmi-container .clmi-pagination .clmi-page {
                background-color: {$btn_color} !important;
                color: {$text_color} !important;
                padding: {$padding} !important;
                border: none !important;
                cursor: pointer;
            }";

            wp_add_inline_style('clmi-css', $custom_css);

            ob_start(); ?>

            <div id="clmi-container"
                data-post-type="<?php echo esc_attr($post_type); ?>"
                data-pagination="<?php echo esc_attr($pagination); ?>">

                <!-- Loader -->
                <div class="clmi-loader" style="display:none;">
                    <?php if (!empty($loader)) : ?>
                        <img src="<?php echo esc_url($loader); ?>" alt="Loading..." style="max-width:50px;" />
                    <?php else : ?>
                        <div class="clmi-default-loader"></div>
                    <?php endif; ?>
                </div>

                <!-- Posts -->
                <div class="clmi-posts"></div>

                <!-- Pagination -->
                <div class="clmi-pagination <?php echo esc_attr($alignment); ?>">

                    <button id="clmi-load-more" style="display:none;">
                        <?php esc_html_e('Load More', 'clmi-ajax-pagination'); ?>
                    </button>

                </div>
            </div>

            <?php
            return ob_get_clean();
        }
}