<?php
if (!defined('ABSPATH')) exit;

class CLMI_Ajax {

    public function __construct() {
        add_action('wp_ajax_clmi_load', [$this, 'load']);
        add_action('wp_ajax_nopriv_clmi_load', [$this, 'load']);
        add_action('rest_api_init', [$this, 'register_routes']);
    }
    public function register_routes() {

        register_rest_route('clmi/v1', '/posts', [
            'methods'  => 'GET',
            'callback' => [$this, 'rest_load'],
            'permission_callback' => '__return_true'
        ]);
    }

    public function rest_load($request) {

        $page = $request->get_param('page') ? absint($request->get_param('page')) : 1;
        $post_type = $request->get_param('post_type') ? sanitize_text_field($request->get_param('post_type')) : 'post';

        $query = new WP_Query([
            'post_type'      => $post_type,
            'posts_per_page' => 5,
            'paged'          => $page
        ]);

        $data = [];

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();

                $data[] = [
                    'title'   => get_the_title(),
                    'link'    => get_permalink(),
                    'image'   => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                    'excerpt' => wp_trim_words(get_the_excerpt(), 10, '...')
                ];
            endwhile;
            wp_reset_postdata();
        endif;

        return [
            'posts' => $data,
            'max'   => $query->max_num_pages
        ];
    }


   public function load() {
        check_ajax_referer('clmi_nonce', 'nonce');
        $page = isset($_POST['page']) ? absint($_POST['page']) : 1;
        $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : 'post';

        $query = new WP_Query([
            'post_type'      => $post_type,
            'posts_per_page' => 5,
            'paged'          => $page
        ]);

        ob_start();

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post(); ?>
            <div class="clmi-post-item">

                <?php if (has_post_thumbnail()) : ?>
                    <div class="clmi-thumb">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="clmi-content">

                    <h3 class="clmi-title">
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <?php echo esc_html(get_the_title()); ?>
                        </a>
                    </h3>

                    <p class="clmi-excerpt">
                        <?php echo esc_html( wp_trim_words(get_the_excerpt(), 10, '...') ); ?>
                    </p>

                </div>

            </div>

        <?php endwhile;

        else : ?>

            <p class="clmi-no-posts">
                <?php esc_html_e('No posts found', 'clmi-ajax-pagination'); ?>
            </p>

        <?php endif;

        wp_reset_postdata();

        $html = ob_get_clean(); //  store once

        wp_send_json_success([
            'html' => $html,
            'max'  => $query->max_num_pages
        ]);
    }
    
    
}
