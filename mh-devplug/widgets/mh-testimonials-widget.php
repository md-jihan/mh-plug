<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Icons_Manager;

class MH_Testimonials_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'mh_testimonials';
    }

    public function get_title() {
        return __('MH Testimonials', 'mhds-plug');
    }

    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return ['mh-plug'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => __('Testimonials', 'mhds-plug'),
                'type' => Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => __('Image', 'mhds-plug'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name' => 'logo_image',
                        'label' => __('Logo', 'mhds-plug'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name' => 'name',
                        'label' => __('Name', 'mhds-plug'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('John Doe', 'mhds-plug'),
                    ],
                    [
                        'name' => 'designation',
                        'label' => __('Designation', 'mhds-plug'),
                        'type' => Controls_Manager::TEXT,
                        'default' => __('CEO, Company', 'mhds-plug'),
                    ],
                    [
                        'name' => 'rating',
                        'label' => __('Rating (1-5)', 'mhds-plug'),
                        'type' => Controls_Manager::NUMBER,
                        'default' => 5,
                        'min' => 1,
                        'max' => 5,
                    ],
                    [
                        'name' => 'comment',
                        'label' => __('Comment', 'mhds-plug'),
                        'type' => Controls_Manager::TEXTAREA,
                        'default' => __('Great service!', 'mhds-plug'),
                    ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'mh_navigation_section',
            [
                'label' => __('Navigation', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'navArrow',
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
			'left-arrow-icon',
			[
				'label' => esc_html__( 'Previous Arrow Icon', 'mhds-plug' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-left',
					'library' => 'fa-solid',
				],
                'condition' => [
                    'navArrow' => 'yes',
                ],
				'recommended' => [
					'fa-solid' => [
                        'chevron-left',
						'caret-left',
						'arrow-left',
						'angle-left',
                        'chevron-circle-left',
                        'arrow-circle-left',
                        'caret-square-left',
                        'arrow-circle-left',
                        'angle-double-left',
                        'long-arrow-alt-left',
                        'arrow-alt-circle-left',
					],
					'fa-regular' => [
						'caret-square-left',
						'arrow-alt-circle-left',
					],
				],
			]
		);
        
        $this->add_control(
			'right-arrow-icon',
			[
				'label' => esc_html__( 'Next Arrow Icon', 'mhds-plug' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
                'condition' => [
                    'navArrow' => 'yes',
                ],
				'recommended' => [
					'fa-solid' => [
                        'chevron-right',
						'caret-right',
						'arrow-right',
						'angle-right',
                        'chevron-circle-right',
                        'arrow-circle-right',
                        'caret-square-right',
                        'arrow-circle-right',
                        'angle-double-right',
                        'long-arrow-alt-right',
                        'arrow-alt-circle-right',
					],
					'fa-regular' => [
						'caret-square-right',
						'arrow-alt-circle-right',
					],
				],
			]
		);
        $this->add_control(
            'navDot',
            [
                'label' => __('Navigation Dots', 'mhds-plug'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'mhds-plug'),
                'label_off' => __('No', 'mhds-plug'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'navAutoplay',
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
            'navAutoplayDelaySpeed',
            [
                'label' => __('Delay Time (ms)', 'mhds-plug'),
                'type' => Controls_Manager::NUMBER,
                'min' => 500,
                'max' => 10000,
                'step' => 500,
                'default' => 3000,
            ]
        );
        
        $this->end_controls_section();
        $this->start_controls_section(
            'title_section',
            [
                'label' => __('Title', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        // Heading Color
        $this->add_control(
            'mh-testimonials-title-color',
            [
                'label' => __('Text Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .mh-testimonial-avatar-details h3' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mh-testimonials-title-typography',
                'label' => __('Typography', 'mhds-plug'),
                'selector' => '{{WRAPPER}}  .mh-testimonial-avatar-details h3',
            ]
        );

        // Text Shadow Control (Now Dynamic)
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mh-testimonials-title-text_shadow',
                'label' => __('Text Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}}  .mh-testimonial-avatar-details h3'
            ]
        );

        // Background Color Control
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mh-testimonials-title-bg_color',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .mh-testimonial-avatar-details h3',
			]
		);
        $this->add_responsive_control(
            'mh-testimonials-title-alignment',
            [
                'label' => __( 'Alignment', 'mhds-plug' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} . .mh-testimonial-avatar-details h3' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'mh-testimonials-title-padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => false,
                ],
    
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-avatar-details h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        // Padding Control
        $this->add_responsive_control(
            'mh-testimonials-title-margin',
            [
                'label' => __( 'Margin', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-avatar-details h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'desc_section',
            [
                'label' => __('Designation', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        // Heading Color
        $this->add_control(
            'mh-testimonials-desc-color',
            [
                'label' => __('Text Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-avatar-details p' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mh-testimonials-desc-typography',
                'label' => __('Typography', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-testimonial-avatar-details p',
            ]
        );

        // Text Shadow Control (Now Dynamic)
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mh-testimonials-desc-text_shadow',
                'label' => __('Text Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-testimonial-avatar-details p'
            ]
        );

        // Background Color Control
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mh-testimonials-desc-bg_color',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .mh-testimonial-avatar-details p',
			]
		);
        $this->add_responsive_control(
            'mh-testimonials-desc-alignment',
            [
                'label' => __( 'Alignment', 'mhds-plug' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .mh-testimonial-avatar-details p' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'mh-testimonials-desc-padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => true,
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .mh-testimonial-avatar-details p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        // Padding Control
        $this->add_responsive_control(
            'mh-testimonials-desc-margin',
            [
                'label' => __( 'Margin', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mh-testimonial-avatar-details p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'comments_section',
            [
                'label' => __('comments', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        // Heading Color
        $this->add_control(
            'mh-testimonials-comments-color',
            [
                'label' => __('Text Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-comment' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mh-testimonials-comments-typography',
                'label' => __('Typography', 'mhds-plug'),
                'selector' => '{{WRAPPER}}  .mh-testimonial-comment',
            ]
        );

        // Text Shadow Control (Now Dynamic)
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mh-testimonials-comments-text_shadow',
                'label' => __('Text Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}}  .mh-testimonial-comment'
            ]
        );

        // Background Color Control
        
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'mh-testimonials-comments-bg_color',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}  .mh-testimonial-comment',
			]
		);
        $this->add_responsive_control(
            'mh-testimonials-comments-alignment',
            [
                'label' => __( 'Alignment', 'mhds-plug' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'mhds-plug' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-comment' => 'text-align: {{VALUE}};width:100%',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'mh-testimonials-comments-padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '20',
                    'right' => '0',
                    'bottom' => '20',
                    'left' => '0',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => false,
                ],
    
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-comment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        // Padding Control
        $this->add_responsive_control(
            'mh-testimonials-comments-margin',
            [
                'label' => __( 'Margin', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'rating_section',
            [
                'label' => esc_html__('Rating Settings', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        
        // Rating Icon Size Control
        $this->add_control(
            'rating_icon_size',
            [
                'label' => esc_html__('Rating Icon Size', 'mhds-plug'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 3,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-rating' => 'font-size: {{SIZE}}{{UNIT}};',  // Apply to font-size for the rating stars
                ],
            ]
        );
        
        // Rating Icon Color Control
        $this->add_control(
            'rating_icon_color',
            [
                'label' => esc_html__('Rating Icon Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ff9800',  // Default color (gold)
                'selectors' => [
                    '{{WRAPPER}}  .mh-testimonial-rating' => 'color: {{VALUE}};',  // Apply the color to the rating stars
                ],
            ]
        );
        
        
        $this->end_controls_section();
        
        $this->start_controls_section(
            'testimonials-arrow',
            [
                'label' => __('Navigation', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navArrow' => 'yes',
                ],
            ]
        );
        $this->start_controls_tabs('navArrow-tabs');
        
        $this->start_controls_tab(
            'normal-arrow-tab',
            [
                'label' => __('Normal', 'mhds-plug'),
            ]
        );
        $this->add_control(
            'navArrow_color',
            [
                'label' => __('Navagition Arrow Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}}  .mh-prev svg,{{WRAPPER}} .mh-next svg ' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'navArrow_bg_color',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mh-prev, {{WRAPPER}} .mh-next',
            ]
        );
        // Box Shadow (Normal)
$this->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'navArrow_box_shadow',
        'label' => esc_html__('Box Shadow', 'mhds-plug'),
        'selector' => '{{WRAPPER}} .mh-prev, {{WRAPPER}} .mh-next',
    ]
);
        $this->end_controls_tab();
        $this->start_controls_tab(
            'hover-arrow-tab',
            [
                'label' => __('Hover', 'mhds-plug'),
            ]
        );
        $this->add_control(
            'navArrow_hover_color',
            [
                'label' => __('Navagition Arrow Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .mh-prev:hover svg,{{WRAPPER}} .mh-next:hover svg ' => 'fill: {{VALUE}};',
                ],
            ]

        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'navArrow_bg_hover_color',
                
				'types' => [ 'classic', 'gradient' ],
                'default' => '#00000000',
                'selectors' => [
                    '{{WRAPPER}} .mh-prev:hover svg,{{WRAPPER}} .mh-next:hover svg ',
                ],
            ]
        );
        // Box Shadow (Hover)
$this->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'navArrow_box_shadow_hover',
        'label' => esc_html__('Box Shadow (Hover)', 'mhds-plug'),
        'selector' => '{{WRAPPER}} .mh-prev:hover, {{WRAPPER}} .mh-next:hover',
    ]
);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_responsive_control(
            'mh-testimonials-navarrow-Size',
            [
                'label' => __( 'Arrow Size', 'mhds-plug' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%'=> [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => '20',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .mh-prev svg,{{WRAPPER}} .mh-next svg ' => 'width: {{size}}{{unit}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mh-testimonials-navarrow-padding',
            [
                'label' => __( 'Padding', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => false,
                ],
    
                'selectors' => [
                    '{{WRAPPER}} .mh-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                    '{{WRAPPER}} .mh-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        $this->add_responsive_control(
            'mh-Navarrow-alignment',
            [
                'label' => __( 'Position', 'mhds-plug' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    
                    'center' => [
                        'title' => __( 'Center', 'mhds-plug' ),
                        'icon' => 'eicon-align-center-v',
                    ],
                    'top' => [
                        'title' => __( 'Top', 'mhds-plug' ),
                        'icon' => 'eicon-align-start-v',
                    ],
                    'bottom' => [
                        'title' => __( 'Bottom', 'mhds-plug' ),
                        'icon' => 'eicon-align-end-v',
                    ],
                    
                ],
                'default' => 'bottom',
                'prefix_class' => 'mh-navArrow-alignment-',
                
            ]
        );
        $this->add_responsive_control(
            'mh-Navarrow-space',
            [
                'label' => __( 'Alignment', 'mhds-plug' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'mhds-plug' ),
                        'icon' => 'eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'mhds-plug' ),
                        'icon' => 'eicon-justify-center-h',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'mhds-plug' ),
                        'icon' => 'eicon-justify-end-h',
                    ],
                    'between' => [
                        'title' => __( 'Between', 'mhds-plug' ),
                        'icon' => 'eicon-justify-space-between-h',
                    ],
                    
                ],
                'default' => 'right',
                'prefix_class' => 'mh-navArrow-space-',
                
            ]
        );
        // Padding Control
        $this->add_responsive_control(
            'mh-testimonials-navarrow-margin',
            [
                'label' => __( 'Margin', 'mhds-plug' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px', // You can set the default unit you prefer (px, %, em, etc.)
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mh-prev' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                    '{{WRAPPER}} .mh-next' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        // Border Control
$this->add_group_control(
    Group_Control_Border::get_type(),
    [
        'name' => 'navArrow_border',
        'label' => esc_html__('Border', 'mhds-plug'),
        'selector' => '{{WRAPPER}} .mh-prev, {{WRAPPER}} .mh-next',
    ]
);

// Border Color Control
$this->add_control(
    'navArrow_border_color',
    [
        'label' => esc_html__('Border Color', 'mhds-plug'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .mh-prev, {{WRAPPER}} .mh-next' => 'border-color: {{VALUE}};',
        ],
    ]
);

// Border Radius Control
$this->add_control(
    'navArrow_border_radius',
    [
        'label' => esc_html__('Border Radius', 'mhds-plug'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 50,
            ],
            '%' => [
                'min' => 0,
                'max' => 50,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .mh-prev, {{WRAPPER}} .mh-next' => 'border-radius: {{SIZE}}{{UNIT}};',
        ],
    ]
);



$this->add_control(
    'testimonial_dots_color',
    [
        'label' => __('Dots Color', 'mhds-plug'),
        'type' => Controls_Manager::COLOR,
        'default' => '#000',
        'selectors' => [
            '{{WRAPPER}} .slick-dots li.slick-active button:before' => 'color: {{value}}',
        ]
        
    ]
);
$this->add_responsive_control(
    'testimonial_dots_size',
    [
        'label' => __( 'Dots size', 'mhds-plug' ),
        'type' => Controls_Manager::NUMBER,
        'default' => 10,
        'selectors' =>[
            '{{WRAPPER}} .slick-dots li button:before' => 'font-size: {{value}}px',
        ]
    ]
);
        $this->end_controls_section();
$this->start_controls_section(
    'testimonial_image_section',
    [
        'label'=> __('Image', 'mhds-plug'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);
        // Image Size Control
        $this->add_control(
            'testimonial_image_size',
            [
                'label' => esc_html__('Image Size', 'mhds-plug'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 250,
                    ], 
                    'em'=>[
                        'min' => 0,
                        'max' => 150,
                    ]
                ],
                'default' => [
                    'size' => 80,
                    'unit' => 'px',
                ],

                'selectors' => [
                    '{{WRAPPER}} .mh-testimonial-avatar-img img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ], // Optional: to give some space above
            ]
        );
// Image Border Radius Control
$this->add_control(
    'testimonial_image_border_radius',
    [
        'label' => __('Image Border Radius', 'mhds-plug'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 200,
            ],
            '%' => [
                'min' => 0,
                'max' => 100,
            ],
        ],
        'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],

        'selectors' => [
            '{{WRAPPER}} .mh-testimonial-avatar-img img' => 'border-radius: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();
$this->start_controls_section(
    'logo_image_section',
    [
        'label' => esc_html__('Logo Image Settings', 'mhds-plug'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);



// Logo Image Width Control
$this->add_control(
    'logo_image_width',
    [
        'label' => esc_html__('Logo Image Width', 'mhds-plug'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
            'px' => [
                'min' => 10,
                'max' => 500,
            ],
            '%' => [
                'min' => 10,
                'max' => 100,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .mh-logo-image img' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

// Logo Image Height Control
$this->add_control(
    'logo_image_height',
    [
        'label' => esc_html__('Logo Image Height', 'mhds-plug'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
            'px' => [
                'min' => 10,
                'max' => 500,
            ],
            '%' => [
                'min' => 10,
                'max' => 100,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .mh-logo-image img' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

// Logo Image Padding Control
$this->add_control(
    'logo_image_padding',
    [
        'label' => esc_html__('Logo Image Padding', 'mhds-plug'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .mh-logo-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Logo Image Margin Control
$this->add_control(
    'logo_image_margin',
    [
        'label' => esc_html__('Logo Image Margin', 'mhds-plug'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .mh-logo-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();
$this->start_controls_section(
    'slider_body_style',
    [
        'label' => esc_html__('Slider Body Style', 'mhds-plug'),
        'tab'   => Controls_Manager::TAB_STYLE,
    ]
);

// Background Color
$this->add_group_control(
    Group_Control_Background::get_type(),
    [
        'name'     => 'slider_body_background',
        'label'    => esc_html__('Background', 'mhds-plug'),
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .mh-testimonial-item',
    ]
);

// Padding Control
$this->add_control(
    'slider_body_padding',
    [
        'label'      => esc_html__('Padding', 'mhds-plug'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em'],
        'selectors'  => [
            '{{WRAPPER}} .mh-testimonial-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

// Border Control
$this->add_group_control(
    Group_Control_Border::get_type(),
    [
        'name'     => 'slider_body_border',
        'label'    => esc_html__('Border', 'mhds-plug'),
        'selector' => '{{WRAPPER}} .mh-testimonial-item',
    ]
);

// Border Radius
$this->add_control(
    'slider_body_border_radius',
    [
        'label'      => esc_html__('Border Radius', 'mhds-plug'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range'      => [
            'px' => [
                'min' => 0,
                'max' => 100,
            ],
            '%'  => [
                'min' => 0,
                'max' => 50,
            ],
        ],
        'selectors'  => [
            '{{WRAPPER}} .mh-testimonial-item' => 'border-radius: {{SIZE}}{{UNIT}};',
        ],
    ]
);

// Box Shadow Control
$this->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'slider_body_box_shadow',
        'label'    => esc_html__('Box Shadow', 'mhds-plug'),
        'selector' => '{{WRAPPER}} .mh-testimonial-item',
    ]
);
$this->add_control(
    'slider_body_align_items',
    [
        'label' => esc_html__('Alignment', 'mhds-plug'),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => esc_html__('Left', 'mhds-plug'),
                'icon' => 'eicon-h-align-left',
            ],
            'center' => [
                'title' => esc_html__('Center', 'mhds-plug'),
                'icon' => 'eicon-h-align-center',
            ],
            'flex-end' => [
                'title' => esc_html__('Bottom', 'mhds-plug'),
                'icon' => 'eicon-h-align-right',
            ],
        ],
        'default' => 'center',
        'selectors' => [
            '{{WRAPPER}} .mh-testimonial-item' => 'align-items: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
<div class="mh-testimonials-container">
    <div class="mh-testimonials-slider">
        <?php foreach ($settings['testimonials'] as $testimonial) : ?>
        <div class="mh-testimonial-item">
            <div class="mh-quote-icon">
                <?php 
                        
                        if (!empty($testimonial['logo_image']['url'])): ?>
                <img src="<?php echo esc_url($testimonial['logo_image']['url']); ?>"
                    alt="<?php echo esc_attr($testimonial['name']); ?>" />
                <?php endif; ?>

            </div>
            <div class="mh-testimonial-rating">
                <?php 
                    for ($i = 0; $i < 5; $i++) {
                        echo $i < $testimonial['rating'] ? '★' : '☆';
                    }
                ?>
            </div>

            <p class="mh-testimonial-comment"><?php echo esc_html($testimonial['comment']); ?></p>
            <div class="mh-testimonial-info">
                <div class="mh-testimonial-avatar">
                    <div class="mh-testimonial-avatar-img">
                        <img src="<?php echo esc_url($testimonial['image']['url']); ?>"
                            alt="<?php echo esc_attr($testimonial['name']); ?>">
                    </div>
                    <div class="mh-testimonial-avatar-details">
                        <h3><?php echo esc_html($testimonial['name']); ?></h3>
                        <p class="mh-testimonial-designation"> <?php echo esc_html($testimonial['designation']); ?> </p>

                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if($settings['navArrow']):?>
    <div class="mh-testimonials-arrows">
        <button class="mh-prev"><?php Icons_Manager::render_icon( $settings['left-arrow-icon'], [ 'aria-hidden' => 'true' ] ); ?></button>
        <button class="mh-next "><?php Icons_Manager::render_icon( $settings['right-arrow-icon'], [ 'aria-hidden' => 'true' ] ); ?></button>
    </div>
    <?php endif;?>
</div>
<script>
    jQuery(document).ready(function ($) {
        var maxHeight = 0;

        // Calculate the maximum height of all testimonials
        $('.mh-testimonial-item').each(function () {
            var thisHeight = $(this).outerHeight();
            if (thisHeight > maxHeight) {
                maxHeight = thisHeight;
            }
        });

        // Set all testimonials to the maximum height
        $('.mh-testimonial-item').each(function () {
            $(this).height(maxHeight);
        });

        // Initialize Slick slider
        $('.mh-testimonials-slider').slick({
            dots: <?php echo $settings['navDot'] === 'yes'? 'true' : 'false';?>,
            arrows: true,
            prevArrow: $('.mh-prev'),
            nextArrow: $('.mh-next'),
            infinite: true,
            autoplay: <?php echo $settings['navAutoplay'] === 'yes'? 'true': 'false';?>,
            autoplaySpeed: <?php echo $settings['navAutoplayDelaySpeed']; ?>,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
</script>
<style>
    .mh-prev, .mh-next {
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mh-prev i, .mh-next i {
    font-size: 24px; /* Adjust size */
}

    .mh-testimonials-container .slick-dots{
        bottom: 0;
    }

    .mh-testimonials-container {
        position: relative;
    }
    .slick-dotted.slick-slider {
    margin-bottom: 0px;
}
    .mh-testimonial-avatar-details h3,
    .mh-testimonial-avatar-details p {
        margin: 0px 0px 5px 0px;
    }

    .mh-quote-icon img {
        max-width: 20px;
        height: auto;
        display: block;
    }


    .mh-quote-icon img {
        width: 60px;
    }

    .mh-testimonials-slider {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: stretch;
    }

    .mh-testimonial-item {
        display: flex !important;
        flex-direction: column;
        align-items: flex-start;
        flex: 1;
        justify-content: flex-end;
        /* Make all items take equal space */
    }

    .mh-testimonial-avatar {
        display: flex;
        align-items: center;
    }


    .mh-testimonial-rating {
        margin-top: 5px;
    }

    .mh-navArrow-alignment-center .mh-testimonials-arrows {
        top: 50%;
        transform: translateY(-50%);
    }
    .mh-navArrow-alignment-top .mh-testimonials-arrows {
        top: 10%;
    }
    .mh-navArrow-alignment-bottom .mh-testimonials-arrows {
        
        bottom: 10%;
    }
    .mh-navArrow-space-between .mh-testimonials-arrows{
        justify-content: space-between;
    }
    .mh-navArrow-space-center .mh-testimonials-arrows{
        justify-content: center;
    }
    .mh-navArrow-space-right .mh-testimonials-arrows{
        justify-content: flex-end;
        right: 3%;
    }
    .mh-navArrow-space-left .mh-testimonials-arrows{
        justify-content: flex-start;
        left: 3%;
    }
    .mh-testimonials-arrows {
        position: absolute;
        display: flex;
        width: 100%;
    }


</style>
<?php
    }
}