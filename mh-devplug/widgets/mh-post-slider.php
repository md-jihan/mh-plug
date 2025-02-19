<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

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
                'step' => 1,
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
                'label' => __('Delay Time (ms)', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'min' => 500,
                'max' => 10000,
                'step' => 500,
                'default' => 3000,
            ]
        );
        $this->add_control(
            'navarrow',
            [
                'label' => __('Navigation Arrow', 'mhds-plug'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'mhds-plug'),
                'label_off' => __('No', 'mhds-plug'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'dots',
            [
                'label' => __('Dots', 'mhds-plug'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'mhds-plug'),
                'label_off' => __('No', 'mhds-plug'),
                'return_value' => 'yes',
                'default' => 'yes',
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
                'default' => '#333',
                'selectors' => [
                    '{{WRAPPER}} .mh-slider-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .mh-slider-title',
            ]
        );
        
        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => true,
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .mh-slider-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
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
            'excerpt_color',
            [
                'label' => __('Excerpt Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#666',
                'selectors' => [
                    '{{WRAPPER}} .mh-slider-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .mh-slider-excerpt',
            ]
        );
        $this->add_responsive_control(
            'excerpt_padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => true,
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .mh-slider-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );

        $this->end_controls_section();
        
        // Excerpt Style
        $this->start_controls_section(
            'navarrow_dots_style_section',
            [
                'label' => __('Navigation & Dots', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'navarrow_color',
            [
                'label' => __('Navigation Arrow Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                
            ]
        );
        $this->add_control(
            'navarrow_bg_color',
            [
                'label' => __('Navigation Arrow Background Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => 'lightgray',
                'selectors' => [
                    '{{WRAPPER}} .mh-post-slider .slick-prev,.mh-post-slider .slick-next' => 'background-color: {{value}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'navarrow_size',
            [
                'label' => __( 'Navigation Arraw size', 'mhds-plug' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
    
                'selectors' => [
                    '{{WRAPPER}} .mh-post-slider .slick-prev:before,.mh-post-slider .slick-next:before' => 'font-size: {{size}}px;', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        $this->add_responsive_control(
            'navarrow_padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => true,
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .mh-post-slider .slick-prev,.mh-post-slider .slick-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );


        $this->add_control(
            'dots_color',
            [
                'label' => __('Dots Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                
            ]
        );
        $this->add_responsive_control(
            'dots_size',
            [
                'label' => __( 'Dots size', 'mhds-plug' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
    
                
            ]
        );

        $this->end_controls_section();

         $this->start_controls_section(
            'slider_style_section',
            [
                'label' => __('Post Slider', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'post_slider_color',
            [
                'label' => __('Excerpt Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#666',
                'selectors' => [
                    '{{WRAPPER}} .slick-slider .mh-slider-item-body' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'post_slider_padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => true,
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .slick-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        $this->add_responsive_control(
            'post_slider_border_radius',
            [
                'label' => __( 'Border radius', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => true,
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .slick-slider .mh-slider-item-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_slider_shadow',
                'label' => __('Box Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .slick-slider .mh-slider-item-body',
            ]
        );
    

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $posts_per_slide = $settings['posts_per_slide'];
        $slide_delay = $settings['slide_delay'];
        $autoplay = $settings['autoplay'] === 'yes' ? 'true' : 'false';
        $navarrow = $settings['navarrow'] === 'yes' ? 'true' : 'false';
        $dots = $settings['dots'] === 'yes' ? 'true' : 'false';
        $excerpt_length = $settings['excerpt_length'];

        $query = new WP_Query([
            'posts_per_page' => 5,
            'post_status' => 'publish',
        ]);

        if ($query->have_posts()) :
            ?>
<div class="mh-post-slider">
    <?php while ($query->have_posts()) : $query->the_post(); ?>

    <div class="mh-slider-item">
        <div class="mh-slider-item-body">
        <h3 class="mh-slider-title"><?php the_title(); ?></h3>
        <p class="mh-slider-excerpt"><?php echo wp_trim_words(get_the_excerpt(), $excerpt_length); ?></p>
    </div>
    </div>
    <?php endwhile; ?>
</div>
<style>
    .mh-post-slider .slick-prev::before,.mh-post-slider .slick-next::before {
    font-size: 20px;
    
    color: <?php echo $settings['navarrow_color'];?>;
}
.slick-slider .mh-slider-item-body{
    padding: 15px;
}
.slick-dots li button:before{
    font-size: <?php echo $settings['dots_size'];?>px;

}
.slick-dots li.slick-active button:before{
    color: <?php echo $settings['dots_color'];?>;
}
</style>
<script>
    jQuery(document).ready(function ($) {
        $('.mh-post-slider').slick({
            infinite: true,
            speed: 300,
            slidesToShow: <?php echo $posts_per_slide; ?> ,
            slidesToScroll : 1,
            autoplay: <?php echo $autoplay; ?> ,
            autoplaySpeed : <?php echo $slide_delay; ?> ,
            dots: <?php echo $dots;?>,
            arrows: <?php echo $navarrow;?>,
            prevArrow: '<button class="slick-prev"></button>',
            nextArrow: '<button class="slick-next"></button>',
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
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