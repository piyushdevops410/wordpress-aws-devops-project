<?php
if (!defined('ABSPATH')) exit;

class CLMI_Shortcode {

    public function __construct() {
        add_shortcode('clmi_posts', [$this, 'render']);
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
    }

    public function register_assets() {

    wp_enqueue_script(
        'clmi-js',
        CLMI_PLUGIN_URL . 'public/js/ajax.js',
        ['jquery'],
        CLMI_VERSION,
        true
    );

    wp_localize_script('clmi-js', 'clmi_obj', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('clmi_nonce')
    ]);
}

   public function render($atts) {

    $settings = get_option('clmi_settings');
    $post_type = $settings['post_type'] ?? 'post';

    $query = new WP_Query([
        'post_type'      => $post_type,
        'posts_per_page' => 5,
        'paged'          => 1
    ]);

    ob_start();

    if ($query->have_posts()) :

        echo '<div id="clmi-posts-wrap">';

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

        echo '</div>';

        //  IMPORTANT: Load More button
        if ($query->max_num_pages > 1) {
            echo '<button id="clmi-load-more" data-page="1">Load More</button>';
        }

    else :
        echo '<p>No posts found</p>';
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
}
