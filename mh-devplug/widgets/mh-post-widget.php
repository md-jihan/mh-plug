<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MH_Posts_Widget extends Widget_Base {
    public function get_name() {
        return 'mh_posts_widget';
    }

    public function get_title() {
        return __('MH Posts Widget', 'mhds-plug');
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return ['mh-plug'];
    }

   
    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        
        $default_post_types = ['post' => 'Post'];
        $custom_post_types = get_post_types(['public' => true, '_builtin' => false], 'objects');
        foreach ($custom_post_types as $slug => $cpt) {
            $default_post_types[$slug] = $cpt->label;
        }

        $this->add_control(
            'post_type',
            [
                'label' => __('Post Type', 'mhds-plug'),
                'type' => Controls_Manager::SELECT,
                'options' => $default_post_types,
                'default' => 'post',
            ]
        );

        // Number of posts per row
        $this->add_control(
            'posts_per_row',
            [
                'label' => __('Posts Per Row', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 6,
                'default' => 3,
            ]
        );

        // Number of posts per page
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50,
                'default' => 6,
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
                'condition' => [
                    'excerpt' => 'yes',
                ]
            ]
        );
 
        

        $this->end_controls_section();
// Toggle Controls for Post Elements
$this->start_controls_section('display_options', [
    'label' => __('Display Options', 'mhds-plug'),
    'tab' => Controls_Manager::TAB_CONTENT,
]);

$elements = ['title', 'comments', 'tags', 'category', 'excerpt', 'featured_image'];
foreach ($elements as $element) {
    $this->add_control($element, [
        'label' => ucfirst(str_replace('_', ' ', $element)),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
    ]);
}

$this->end_controls_section();
        // Style Sections for Each Element
        
        $elements = ['title', 'excerpt', 'comments', 'tags', 'category'];
        foreach ($elements as $element) {
            $this->start_controls_section(
                "{$element}_style_section",
                [
                    'label' => __(ucfirst($element) . ' Style', 'mhds-plug'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        "{$element}" => 'yes',
                    ]
                ]
            );
            $this->start_controls_tabs("{$element}_tab_color");
            $this->start_controls_tab(
                "normal-{$element}-tab",
                [
                    'label' => __('Normal', 'mhds-plug'),
                ]
            );
            $this->add_control(
                "{$element}_color",
                [
                    'label' => __('Color', 'mhds-plug'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-{$element}" => 'color: {{VALUE}};',
                    ],
                ]
            );
            if ($element === 'category' || $element === 'tags') {
                $this->add_control(
                    "{$element}_link_color",
                    [
                        'label' => __('Link Color', 'mhds-plug'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            "{{WRAPPER}} .mh-post-{$element} a" => 'color: {{VALUE}};',
                        ],
                    ]
                );
            }
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => "{$element}_typography",
                    'selector' => "{{WRAPPER}} .mh-post-{$element}",
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => "{$element}_background",
                    'selector' => "{{WRAPPER}} .mh-post-{$element}",
                ]
            );
            
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => "{$element}_text_shadow",
                    'label' => __('Text Shadow', 'mhds-plug'),
                    'selector' => "{{WRAPPER}} .mh-post-{$element}",
                ]
            );
    

            $this->end_controls_tab();
            $this->start_controls_tab(
                "hover-{$element}-tab",
                [
                    'label' => __('Hover', 'mhds-plug'),
                ]
            );
            $this->add_control(
                "{$element}_hover_color",
                [
                    'label' => __('Hover Color', 'mhds-plug'),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-{$element}:hover" => 'color: {{VALUE}};',
                    ],
                ]
            );
            if ($element === 'category' || $element === 'tags') {
                $this->add_control(
                    "{$element}_hover_link_color",
                    [
                        'label' => __('Link Hover Color', 'mhds-plug'),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            "{{WRAPPER}} .mh-post-{$element} a:hover" => 'color: {{VALUE}};',
                        ],
                    ]
                );
            }
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => "{$element}_hover_typography",
                    'selector' => "{{WRAPPER}} .mh-post-{$element}:hover",
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => "{$element}_hover_background",
                    'selector' => "{{WRAPPER}} .mh-post-{$element}:hover",
                ]
            ); 
            
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name' => "{$element}_hover_text_shadow",
                    'label' => __('Text Shadow', 'mhds-plug'),
                    'selector' => "{{WRAPPER}} .mh-post-{$element}:hover",
                ]
            );
    
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => "{$element}_border",
                    'selector' => "{{WRAPPER}} .mh-post-{$element}",
                ]
            );

            $this->add_responsive_control(
                "{$element}_padding",
                [
                    'label' => __('Padding', 'mhds-plug'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-{$element}" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                "{$element}_margin",
                [
                    'label' => __('Margin', 'mhds-plug'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-{$element}" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->end_controls_section();

            $this->start_controls_section(
                "body_style_section",
                [
                    'label' => __('Body Style', 'mhds-plug'),
                    'tab' => Controls_Manager::TAB_STYLE
                    
                ]
            );
            $this->start_controls_tabs("body_tab_color");
            $this->start_controls_tab(
                "normal-body-tab",
                [
                    'label' => __('Normal', 'mhds-plug'),
                ]
            );
           
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => "body_background",
                    'selector' => "{{WRAPPER}} .mh-post-card",
                ]
            );
            
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => "body_box_shadow",
                    'label' => __('Box Shadow', 'mhds-plug'),
                    'selector' => "{{WRAPPER}} .mh-post-card",
                ]
            );
    

            $this->end_controls_tab();
            $this->start_controls_tab(
                "hover-body-tab",
                [
                    'label' => __('Hover', 'mhds-plug'),
                ]
            );
            
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => "body_hover_background",
                    'selector' => "{{WRAPPER}} .mh-post-card:hover",
                ]
            ); 
            
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => "body_hover_box_shadow",
                    'label' => __('Box Shadow', 'mhds-plug'),
                    'selector' => "{{WRAPPER}} .mh-post-card:hover",
                ]
            );
    
            $this->end_controls_tab();
            $this->end_controls_tabs();
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => "body_border",
                    'selector' => "{{WRAPPER}} .mh-post-card",
                ]
            );
            $this->add_responsive_control(
                "body_border_radius",
                [
                    'label' => __('Border Radius', 'mhds-plug'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-card" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                "body_padding",
                [
                    'label' => __('Padding', 'mhds-plug'),
                    'type' => Controls_Manager::DIMENSIONS,
                    
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-card" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                "body_margin",
                [
                    'label' => __('Margin', 'mhds-plug'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-card" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            

            $this->end_controls_section();
            
             $this->start_controls_section(
                 "featured_image_style_section",
                 [
                    'label' => __('Featured Image Style', 'mhds-plug'),
                    'tab' => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'featured_image' => 'yes',
                    ]
                 ]
             );
             
            // Featured Image Size Control
            $this->add_group_control(
                Group_Control_Image_Size::get_type(),
                [
                    'name' => 'featured_image_size',
                    'label' => __('Featured Image Size', 'mhds-plug'),
                    'default' => 'medium',
                    'separator' => 'none',
                    'selector' => '{{WRAPPER}} .mh-post-thumbnail img',
                ]

            );
            $this->add_control(
                'featured_image_fixid_size_switch',
            [
                'label' => __('Image Height',  'mhds-plug'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]);
            $this->add_responsive_control(
                'featured_image_fixid_size',
                [
                    'label' => __('Image height Size', 'mhds-plug'),
                    'type' => Controls_Manager::NUMBER,
                    'min' => 50,
                    'max' => 700,
                    'step' => 5,
                    'default' => 300,
                    'condition' => [
                        'featured_image_fixid_size_switch' => 'yes',
                    ]
                ]
            );
            $this->add_responsive_control(
                "featured_image_border_radius",
                [
                    'label' => __('Border Radius', 'mhds-plug'),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'selectors' => [
                        "{{WRAPPER}} .mh-post-thumbnail img" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
        
            $this->end_controls_section();
        }
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['posts_per_page'],
        ];
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            echo '<div class="mh-posts-grid" style="display: grid; grid-template-columns: repeat(' . esc_attr($settings['posts_per_row']) . ', 1fr); gap: 20px; ">';
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="mh-post-card">';

                $image_size = isset($settings['featured_image_size_size']) ? $settings['featured_image_size_size'] : 'medium';

                if ($settings['featured_image'] === 'yes' && has_post_thumbnail()) {
                    echo '<div class="mh-post-thumbnail">' . get_the_post_thumbnail(get_the_ID(), $image_size) . '</div>';
                }
                if ($settings['title'] === 'yes') {
                    echo '<h3><a class="mh-post-title" href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                }
                echo "<div style='display:flex; align-items: center;gap: 5px;'>";
                if ($settings['comments'] === 'yes') {
                    echo '<p class="mh-post-comments">Comments: ' . get_comments_number() . '</p>';
                }
                if ($settings['category'] === 'yes' && has_category()) {
                    echo '<p class="mh-post-category">Category: ' . get_the_category_list(', ') . '</p>';
                }
                if ($settings['tags'] === 'yes' && has_tag()) {
                    echo '<p class="mh-post-tags">Tags: ' . get_the_tag_list('', ', ') . '</p>';
                }
                echo "</div>";
                if ($settings['excerpt'] === 'yes') {
                    echo '<p class="mh-post-excerpt">' . wp_trim_words(get_the_excerpt(), $settings['excerpt_length']) . '</p>';
                }
                echo '</div>';
            }
            echo '</div>';
            
            wp_reset_postdata();
        } else {
            echo '<p>No posts found.</p>';
        }
if ($settings['featured_image_fixid_size_switch'] === 'yes') {
    # code...
echo '<style>
    
    .mh-post-thumbnail img{
        height: '.$settings['featured_image_fixid_size'].'px;
    }
</style>';
    }
}
}



add_action('elementor/widgets/register', function($widgets_manager) {
    $widgets_manager->register_widget_type(new MH_Posts_Widget());
});
