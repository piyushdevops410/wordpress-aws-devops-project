<?php
if (!defined('ABSPATH')) exit;

// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound -- $attributes is provided by register_block_type render_callback
$attributes = wp_parse_args($attributes, [
    'title'        => '',
    'content'      => '',
    'buttonText'   => 'Click Here',
    'buttonURL'    => '#',
    'bgColor'      => '#f5f5f5',
    'textColor'    => '#000',
    'buttonColor'  => '#0073aa',
    'alignment'    => 'center',
    'fullWidth'    => false,
    'maxWidth'     => '1200px',
    'padding'      => '30px',
    'borderRadius' => '8px',
    'boxShadow'    => 'none',
]);

if (empty($attributes['title']) && empty($attributes['content'])) return;
?>

<div class="cta-outer" style="<?php echo $attributes['fullWidth'] ? '' : 'padding:20px;'; ?>">

    <div class="cta-wrapper"
        style="<?php echo esc_attr(
            'background:' . $attributes['bgColor'] . ';
            color:' . $attributes['textColor'] . ';
            text-align:' . $attributes['alignment'] . ';
            padding:' . $attributes['padding'] . ';
            border-radius:' . $attributes['borderRadius'] . ';
            box-shadow:' . $attributes['boxShadow'] . ';
            max-width:' . ($attributes['fullWidth'] ? '100%' : $attributes['maxWidth']) . ';
            margin:0 auto;'
        ); ?>">

        <?php if (!empty($attributes['title'])) : ?>
            <h2><?php echo esc_html($attributes['title']); ?></h2>
        <?php endif; ?>

        <?php if (!empty($attributes['content'])) : ?>
            <p><?php echo esc_html($attributes['content']); ?></p>
        <?php endif; ?>

        <a href="<?php echo esc_url($attributes['buttonURL']); ?>"
           style="<?php echo esc_attr(
               'background:' . $attributes['buttonColor'] . ';
                color:#fff;
                padding:10px 20px;
                display:inline-block;
                text-decoration:none;'
           ); ?>">
            <?php echo esc_html($attributes['buttonText']); ?>
        </a>

    </div>

</div>