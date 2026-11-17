<?php
/**
 * Title: Testimonials
 * Slug: coreflux/testimonials
 * Categories: coreflux
 */
?>

<!-- wp:group {"align":"wide"} -->
<div class="wp-block-group alignwide">

    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="has-text-align-center">
        <?php echo esc_html__('What Our Users Say', 'coreflux'); ?>
    </h2>
    <!-- /wp:heading -->

    <!-- wp:columns -->
    <div class="wp-block-columns">

        <!-- wp:column -->
        <div class="wp-block-column">
            <p><?php echo esc_html__('Amazing theme, very flexible!', 'coreflux'); ?></p>
            <strong><?php echo esc_html__('John Doe', 'coreflux'); ?></strong>
        </div>

        <!-- wp:column -->
        <div class="wp-block-column">
            <p><?php echo esc_html__('Perfect for modern websites.', 'coreflux'); ?></p>
            <strong><?php echo esc_html__('Jane Smith', 'coreflux'); ?></strong>
        </div>

    </div>

</div>
<!-- /wp:group -->