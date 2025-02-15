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
                    '{{WRAPPER}} h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __('Typography', 'mhds-plug'),
                'selector' => '{{WRAPPER}} h2',
            ]
        );

        // Text Shadow Control (Now Dynamic)
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'heading_text_shadow',
                'label' => __('Text Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} h2',
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
                    '{{WRAPPER}} h2' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        echo '<h2>' . esc_html($settings['heading_text']) . '</h2>';
    }

    
}