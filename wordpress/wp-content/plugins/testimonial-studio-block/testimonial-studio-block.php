<?php
/**
 * Plugin Name: Testimonial Studio Block
 * Description: Gutenberg testimonial slider block.
 * Version: 1.0.0
 * Author: Piyush Koshti
 * Text Domain: testimonial-studio-block
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* Load block editor script */

function tsb_register_block(){

wp_register_script(
'tsb-block',
plugins_url('index.js',__FILE__),
array('wp-blocks','wp-editor','wp-components','wp-element'),
filemtime(plugin_dir_path(__FILE__).'index.js'),
true 
);

wp_register_style(
'tsb-style',
plugins_url('style.css', __FILE__),
array(),
filemtime(plugin_dir_path(__FILE__) . 'style.css')
);

wp_register_style(
'tsb-editor',
plugins_url('editor.css', __FILE__),
array(),
filemtime(plugin_dir_path(__FILE__) . 'editor.css')
);

register_block_type('testimonial-studio/block',array(
'editor_script'=>'tsb-block',
'style'=>'tsb-style',
'editor_style'=>'tsb-editor'
));

}

add_action('init','tsb_register_block');


/* Load frontend slider */

function tsb_load_slider_assets(){

wp_enqueue_style(
'tsb-swiper-css',
plugins_url('swiper-bundle.min.css', __FILE__),
array(),
filemtime(plugin_dir_path(__FILE__) . 'swiper-bundle.min.css')
);

wp_enqueue_script(
'tsb-swiper-js',
plugins_url('swiper-bundle.min.js', __FILE__),
array(),
filemtime(plugin_dir_path(__FILE__) . 'swiper-bundle.min.js'),
true
);

wp_enqueue_script(
'tsb-slider',
plugins_url('slider.js',__FILE__),
array('tsb-swiper-js'),
'1.0',
true
);

}

add_action('wp_enqueue_scripts','tsb_load_slider_assets');