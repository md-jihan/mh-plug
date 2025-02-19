<?php
if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;

class MH_Button_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'mh_button';
    }

    public function get_title() {
        return __('MH Button', 'mhds-plug');
    }

    public function get_icon() {
        return 'eicon-button';
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
            'button_text',
            [
                'label' => __('Button Text', 'mhds-plug'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Click Me', 'mhds-plug'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => __('Button URL', 'mhds-plug'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'mhds-plug'),
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        // Style Section - Normal and Hover Tabs
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Button Style', 'mhds-plug'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Normal Styles
        $this->start_controls_tabs('button_style_tabs');

        $this->start_controls_tab(
            'normal_button_tab',
            [
                'label' => __('Normal', 'mhds-plug'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-button-widget' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Background Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0073e6',
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-button-widget' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        // Text Shadow Control (Now Dynamic)
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'button_text_shadow',
                'label' => __('Text Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-button-widget'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => __('Box Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-button-widget'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __('Border', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-button-widget',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Typography', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-button-widget',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'mhds-plug'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-button-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab(); // End Normal Tab

        // Hover Styles
        $this->start_controls_tab(
            'hover_button_tab',
            [
                'label' => __('Hover', 'mhds-plug'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => __('Text Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-button-widget:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => __('Background Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#005bb5',
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-button-widget:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __('Border Color', 'mhds-plug'),
                'type' => Controls_Manager::COLOR,
                'default' => '#004999',
                'selectors' => [
                    '{{WRAPPER}} .mh-plug-button-widget:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'button_hover_text_shadow',
                'label' => __('Text Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-button-widget:hover'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'label' => __('Box Shadow', 'mhds-plug'),
                'selector' => '{{WRAPPER}} .mh-plug-button-widget:hover'
            ]
        );
        $this->end_controls_tab(); // End Hover Tab

        $this->end_controls_tabs(); // End Tabs
        $this->end_controls_section(); // End Style Section
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['button_url']['url'])) {
            $this->add_render_attribute('button_url', 'href', esc_url($settings['button_url']['url']));
            if ($settings['button_url']['is_external']) {
                $this->add_render_attribute('button_url', 'target', '_blank');
            }
            if ($settings['button_url']['nofollow']) {
                $this->add_render_attribute('button_url', 'rel', 'nofollow');
            }
        }
        ?>
        <style>
            .mh-plug-button-widget {
                display: inline-block;
                text-decoration: none;
                font-weight: bold;
                border-radius: 5px;
                padding: 10px 20px;
                transition: all 0.3s ease-in-out;
            }
        </style>
        <div class="mh-button-container">
            <a <?php echo $this->get_render_attribute_string('button_url'); ?> class="mh-plug-button-widget">
                <?php echo esc_html($settings['button_text']); ?>
            </a>
        </div>
        <?php
    }
}
