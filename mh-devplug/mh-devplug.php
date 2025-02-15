<?php
/**
 * Plugin Name: MH Plug
 * Plugin URI: https://yourwebsite.com
 * Description: A custom Elementor addon with a heading widget.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL2
 * Text Domain: mhds-plug
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Check if Elementor is installed and active
function mh_plug_check_elementor() {
    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p><strong>MH Plug</strong> requires Elementor to be installed and activated.</p></div>';
        });
        return;
    }
    add_action('elementor/widgets/register', 'mh_plug_register_widgets');
}
add_action('plugins_loaded', 'mh_plug_check_elementor');

// Register the Elementor widget
function mh_plug_register_widgets($widgets_manager) {
    require_once plugin_dir_path(__FILE__) . 'widgets/mh-heading-widget.php';  // Make sure this file exists
    require_once plugin_dir_path(__FILE__) . 'widgets/mh-post-slider.php';
    $widgets_manager->register(new MH_Heading_Widget());
    $widgets_manager->register(new MH_Post_Slider_Widget());
}

// Optional: Create widgets folder if doesn't exist (but don’t create the widget file programmatically)
if (!is_dir(plugin_dir_path(__FILE__) . 'widgets')) {
    mkdir(plugin_dir_path(__FILE__) . 'widgets');
}
// Register custom Elementor category for MH widgets
function mh_add_elementor_widget_categories($elements_manager) {
    $elements_manager->add_category(
        'mh-plug',
        [
            'title' => __('MH Plug', 'mhds-plug'),
            'icon'  => 'fa fa-plug', // You can change this icon
        ]
    );
}
add_action('elementor/elements/categories_registered', 'mh_add_elementor_widget_categories');

// function mh_plug_enqueue_scripts() {
//     wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js', ['jquery'], null, true);
//     wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
//     wp_enqueue_style( 'mh-plug-editor-css',
//         plugin_dir_url(__FILE__) . 'assets/style.css',
//         [],
//         '1.0.0');
// }
// add_action('wp_enqueue_scripts', 'mh_plug_enqueue_scripts');
function mh_enqueue_slick_slider() {
    wp_enqueue_style('slick-css', plugin_dir_url(__FILE__) . 'assets/slick.css',[], '1.0.0');
    wp_enqueue_style('slick-theme-css', plugin_dir_url(__FILE__).'assets/slick-theme.css', [], '1.0.0');
    wp_enqueue_script('slick-js', plugin_dir_url(__FILE__).'assets/slick.min.js', array('jquery'), '1.8.1', true);
}
add_action('wp_enqueue_scripts', 'mh_enqueue_slick_slider');

