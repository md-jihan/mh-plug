<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Widget_Base;

class MH_Post_Slider_Widget extends Widget_Base {

    public function get_name() {
        return 'mh_post_slider';
    }

    public function get_title() {
        return __('MH Post Slider', 'mhds-plug');
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return ['mh-plug'];
    }

    protected function _register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_slide',
            [
                'label' => __('Posts per Slide', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 5,
                'default' => 3,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'mhds-plug'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'mhds-plug'),
                'label_off' => __('No', 'mhds-plug'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'slide_delay',
            [
                'label' => __('Slide Delay (ms)', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'min' => 500,
                'max' => 10000,
                'default' => 3000,
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => __('Title', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Title Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .swiper-slide h3' => 'color: {{VALUE}};'],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .swiper-slide h3',
            ]
        );

        $this->add_responsive_control(
            'title_alignment',
            [
                'label' => __('Alignment', 'mhds-plug'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [ 'title' => __('Left', 'mhds-plug'), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'title' => __('Center', 'mhds-plug'), 'icon' => 'eicon-text-align-center' ],
                    'right' => [ 'title' => __('Right', 'mhds-plug'), 'icon' => 'eicon-text-align-right' ],
                ],
                'selectors' => ['{{WRAPPER}} .swiper-slide h3' => 'text-align: {{VALUE}};'],
            ]
        );

        $this->end_controls_section();

        // Excerpt Style
        $this->start_controls_section(
            'excerpt_style_section',
            [
                'label' => __('Excerpt', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Word Limit', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => __('Excerpt Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .swiper-slide p' => 'color: {{VALUE}};'],
            ]
        );
        $this->add_responsive_control(
            'excerpt_alignment',
            [
                'label' => __('Alignment', 'mhds-plug'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [ 'excerpt' => __('Left', 'mhds-plug'), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'excerpt' => __('Center', 'mhds-plug'), 'icon' => 'eicon-text-align-center' ],
                    'right' => [ 'excerpt' => __('Right', 'mhds-plug'), 'icon' => 'eicon-text-align-right' ],
                    'justify' => [ 'excerpt' => __('Justify', 'mhds-plug'), 'icon' => 'eicon-text-align-justify' ],
                ],
                'selectors' => ['{{WRAPPER}} .swiper-slide p' => 'text-align: {{VALUE}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .swiper-slide p',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'nav_dots_style_section',
            [
                'label' => __('Navigation & Dots', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'nav_size',
            [
                'label' => __('Navigation Arrow Size', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => __('Excerpt Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .swiper-slide p' => 'color: {{VALUE}};'],
            ]
        );
        $this->add_responsive_control(
            'excerpt_alignment',
            [
                'label' => __('Alignment', 'mhds-plug'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [ 'excerpt' => __('Left', 'mhds-plug'), 'icon' => 'eicon-text-align-left' ],
                    'center' => [ 'excerpt' => __('Center', 'mhds-plug'), 'icon' => 'eicon-text-align-center' ],
                    'right' => [ 'excerpt' => __('Right', 'mhds-plug'), 'icon' => 'eicon-text-align-right' ],
                    'justify' => [ 'excerpt' => __('Justify', 'mhds-plug'), 'icon' => 'eicon-text-align-justify' ],
                ],
                'selectors' => ['{{WRAPPER}} .swiper-slide p' => 'text-align: {{VALUE}};'],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .swiper-slide p',
            ]
        );

        $this->end_controls_section();
    
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $posts_per_slide = $settings['posts_per_slide'];
        $slide_delay = $settings['slide_delay'];
        $autoplay = $settings['autoplay'] === 'yes' ? 'true' : 'false';
        $excerpt_length = $settings['excerpt_length'];?>
        <style></style><?php
        $query = new WP_Query([
            'posts_per_page' => 5,
            'post_status' => 'publish',
        ]);

        if ($query->have_posts()) :
            ?>
            <div class="mh-post-slider swiper-container">
                <div class="swiper-wrapper">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="swiper-slide">
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), $excerpt_length); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <script>
                jQuery(document).ready(function($) {
                    new Swiper('.mh-post-slider', {
                        slidesPerView: <?php echo $posts_per_slide; ?>,
                        loop: true,
                        autoplay: {
                            delay: <?php echo $slide_delay?>,
                            disableOnInteraction: false,
                        },
                        pagination: { el: '.swiper-pagination', clickable: true },
                        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                    });
                });
            </script>
            <?php
            wp_reset_postdata();
        else :
            echo '<p>No posts found.</p>';
        endif;
    }
}
