<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

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
                'excerpt_length',
                [
                    'label' => __('Excerpt Length', 'mhds-plug'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 5,
                    'max' => 200,
                    'step' => 5,
                    'default' => 50,
                ]
            );
        
            $this->add_control(
                'post_type',
                [
                    'label' => __('Post Type', 'mhds-plug'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        'post' => __('Post', 'mhds-plug'),
                        // Add more post types if needed
                    ],
                    'default' => 'post',
                ]
            );
        
            $this->add_control(
                'show_read_more',
                [
                    'label' => __('Show Read More Button', 'mhds-plug'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'read_more_text',
                [
                    'label' => __('Read More Text', 'mhds-plug'),
                    'type' => Controls_Manager::TEXT,
                    'default' => __('Read More', 'mhds-plug'),
                    'condition' => [
                        'show_read_more' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'dots',
                [
                    'label' => __('Dots', 'mhds-plug'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );
            $this->add_control(
                'navarrow',
                [
                    'label' => __('Nav Arrow', 'mhds-plug'),
                    'type' => Controls_Manager::SWITCHER,
                    'default' => 'yes',
                ]
            );
        
            $this->add_control(
                'left_arrow_icon',
                [
                    'label' => __('Left Arrow Icon', 'mhds-plug'),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-chevron-left',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'navarrow' => 'yes',
                    ],
                ]
            );
            
            $this->add_control(
                'right_arrow_icon',
                [
                    'label' => __('Right Arrow Icon', 'mhds-plug'),
                    'type' => Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-chevron-right',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'navarrow' => 'yes',
                    ],
                ]
            );
            $this->end_controls_section();

                // Style Section
                $this->start_controls_section(
                    'style_section',
                    [
                        'label' => __('Card Style', 'mhds-plug'),
                        'tab' => Controls_Manager::TAB_STYLE,
                    ]
                );
            
                $this->add_control(
                    'card_bg_color',
                    [
                        'label' => __('Card Background Color', 'mhds-plug'),
                        'type' => Controls_Manager::COLOR,
                        'default' => '#ffffff',
                        'selectors' => [
                            '{{WRAPPER}} .mh-slider-item' => 'background-color: {{VALUE}};',
                        ],
                    ]
                );
            
                $this->add_group_control(
                    Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'card_box_shadow',
                        'label' => __('Card Box Shadow', 'mhds-plug'),
                        'selector' => '{{WRAPPER}} .mh-slider-item',
                    ]
                );
            
                $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'card_border',
                        'label' => __('Card Border', 'mhds-plug'),
                        'selector' => '{{WRAPPER}} .mh-slider-item',
                    ]
                );
            
                $this->add_control(
                    'card_border_radius',
                    [
                        'label' => __('Card Border Radius', 'mhds-plug'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .mh-slider-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );
            
                $this->end_controls_section();
        
        }
        
    protected function render() { 
        $settings = $this->get_settings_for_display();
        
            // Render the slider HTML
            $query = new WP_Query([
                'post_type' => $settings['post_type'],
                'posts_per_page' => 5, // Adjust as needed
                'post_status' => 'publish',
            ]);
        
            if ($query->have_posts()) { ?>
                <div class="mh-post-slider">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="mh-slider-item">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="mh-slider-thumbnail">
                                    <?php the_post_thumbnail('medium'); ?>
                                </div>
                            <?php endif; ?>
        
                            <div class="mh-slider-content">
                                <h3 class="mh-slider-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
        
                                <div class="mh-slider-excerpt">
                                    <?php echo wp_trim_words(get_the_excerpt(), $settings['excerpt_length']); ?>
                                </div>
        
                                <?php if ($settings['show_read_more'] === 'yes') : ?>
                                    <a href="<?php the_permalink(); ?>" class="mh-read-more">
                                        <?php echo esc_html($settings['read_more_text']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
        
            <style>
               /* .mh-post-slider {
    width: 100%;
    overflow: hidden;
} */
/* Ensure the slider container has enough padding for the buttons */
.mh-post-slider {
    position: relative;
    padding: 0 0px; 
}


.mh-slider-item {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    z-index: 99999;
    flex-direction: column;
    margin: 0 10px; /* Add margin between slides */
    width: calc(100% - 20px) !important;
}

.mh-slider-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.mh-slider-thumbnail img {
    width: 100%;
    height: 200px; /* Fixed height for thumbnails */
    object-fit: cover; /* Ensure images fill the space */
}

.mh-slider-content {
    padding: 20px;
    flex: 1; /* Allow content to grow and fill remaining space */
    display: flex;
    flex-direction: column;
}

.mh-slider-title {
    margin: 0 0 10px;
    font-size: 18px;
}

.mh-slider-excerpt {
    margin: 0 0 15px;
    font-size: 14px;
    color: #666;
    flex: 1; /* Allow excerpt to grow and fill space */
}

.mh-read-more {
    display: inline-block;
    padding: 8px 16px;
    background: #0073e6;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
    transition: background 0.3s ease;
    align-self: flex-start; /* Align button to the left */
}

.mh-read-more:hover {
    background: #005bb5;
}

/* Style for prev/next buttons */
.slick-prev::before,
.slick-next::before {
    content: "";
}
.slick-prev,
.slick-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    background: rgba(0, 0, 0, 0.5);
    border: none;
    color: #fff;
    font-size: 20px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.slick-prev:hover,
.slick-next:hover {
    background: rgba(0, 0, 0, 0.8);
}

.slick-prev {
    left: -25px; /* Position outside the slider */
}

.slick-next {
    right: -25px; /* Position outside the slider */
}
            </style>
            <script>
             jQuery(document).ready(function ($) {
    // Check if the slider container exists
        $('.mh-post-slider').slick({
            infinite: true,
            speed: 300,
            slidesToShow: <?php echo $settings['posts_per_slide']; ?>,
            slidesToScroll: 1,
            autoplay: <?php echo $settings['autoplay'] === 'yes' ? 'true' : 'false'; ?>,
            autoplaySpeed: <?php echo $settings['slide_delay']; ?>,
            dots: <?php echo $settings['dots'] === 'yes' ? 'true' : 'false'; ?>,
            arrows: <?php echo $settings['navarrow'] === 'yes' ? 'true' : 'false'; ?>,
            prevArrow: '<button class="slick-prev"><?php Icons_Manager::render_icon($settings['left_arrow_icon'], ['aria-hidden' => 'true']); ?></button>',
            nextArrow: '<button class="slick-next"><?php Icons_Manager::render_icon($settings['right_arrow_icon'], ['aria-hidden' => 'true']); ?></button>',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: Math.min(<?php echo $settings['posts_per_slide']; ?>, 3),
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: Math.min(<?php echo $settings['posts_per_slide']; ?>, 2),
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                }
            ]
        });
    



    // Equalize card heights
    function equalizeCardHeights() {
        let maxHeight = 0;

        // Reset heights to auto
        $('.mh-slider-item').css('height', 'auto');

        // Find the tallest card
        $('.mh-slider-item').each(function () {
            const cardHeight = $(this).outerHeight();
            if (cardHeight > maxHeight) {
                maxHeight = cardHeight;
            }
        });

        // Set all cards to the tallest height
        $('.mh-slider-item').css('height', maxHeight + 'px');
    }

    // Run on load and window resize
    equalizeCardHeights();
    $(window).on('resize', equalizeCardHeights);

    // Re-run after Slick Slider initializes
    $('.mh-post-slider').on('init', equalizeCardHeights);
});
            </script>
            <?php
            wp_reset_postdata();
}else {
            echo '<p>No posts found.</p>';
        };
    }
}