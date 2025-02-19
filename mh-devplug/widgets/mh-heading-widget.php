<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Ensure Elementor is loaded before defining the widget
if (!class_exists('\Elementor\Widget_Base')) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

class MH_Heading_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'mh_heading';
    }

    public function get_title() {
        return __('MH Heading', 'mhds-plug');
    }

    public function get_icon() {
        return 'eicon-t-letter';
    }

    public function get_categories() {
        return ['mh-plug'];
    }

    protected function _register_controls() {
        // Content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading_text',
            [
                'label' => __('Heading Text', 'mhds-plug'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Default Heading', 'mhds-plug'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'heading_html_tag',
            [
                'label' => __( 'HTML Tag', 'mhds-plug' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p' => 'P',
                    'div' => 'DIV',
                ],
                'default' => 'h2',
                'description' => __( 'Select the HTML tag for Heading.', 'mhds-plug' ),
            ]
        );
    
        $this->end_controls_section();

        // Style section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Heading Color
        $this->add_control(
            'heading_color',
            [
                'label' => __('Text Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-heading-widget' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __('Typography', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-heading-widget',
            ]
        );

        // Text Shadow Control (Now Dynamic)
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'heading_text_shadow',
                'label' => __('Text Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-heading-widget'
            ]
        );

        // Background Color Control
        $this->add_control(
            'heading_bg_color',
            [
                'label' => __('Background Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f0f0f0',
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-heading-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mh-heading-alignment',
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
                    '{{WRAPPER}} .mh-plug-heading-widget' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'mh-heading-padding',
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
                    '{{WRAPPER}} .mh-plug-heading-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
        // Padding Control
        $this->add_responsive_control(
            'mh-heading-margin',
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
                    '{{WRAPPER}} .mh-plug-heading-widget' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', // Adjust the selector to target your widget's elements
                ],
            ]
        );
    
    

        $this->end_controls_section();
    }

protected function render() {
        $settings = $this->get_settings_for_display();
        $headingtag = !empty($settings['heading_html_tag']) ? $settings['heading_html_tag'] : 'h2'; 
        echo '<'. esc_attr( $headingtag ).' class="mh-plug-heading-widget" >' . esc_html($settings['heading_text']) . '</'. esc_attr( $headingtag ) .'>';
    }

    
}