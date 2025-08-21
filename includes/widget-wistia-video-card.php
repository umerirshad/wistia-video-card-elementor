<?php
/**
 * Wistia Video Card Elementor Widget
 *
 * @package Wistia_Video_Card_Elementor
 */

namespace WistiaVideoCardElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Wistia_Video_Card extends Widget_Base {

    public function get_name() {
        return 'wistia_video_card';
    }

    public function get_title() {
        return __( 'Wistia Video Card', 'wistia-video-card-elementor' );
    }

    public function get_icon() {
        return 'eicon-video-camera';
    }

    public function get_categories() {
        return [ 'general' ];
    }

    public function get_keywords() {
        return [ 'wistia', 'video', 'embed', 'card' ];
    }

    public function get_script_depends() {
        return [];
    }

    public function get_style_depends() {
        return [];
    }

    protected function register_controls() {

        // --- Content Section ---
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'wistia-video-card-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_url',
            [
                'label'       => __( 'Wistia Video URL or ID', 'wistia-video-card-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( 'Example: https://wistia.com/medias/abcd1234 OR abcd1234', 'wistia-video-card-elementor' ),
                'label_block' => true,
                'description' => __( 'Enter a Wistia video URL or just the video ID', 'wistia-video-card-elementor' ),
            ]
        );

        // Title Toggle
        $this->add_control(
            'show_title',
            [
                'label'        => __( 'Show Title', 'wistia-video-card-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'wistia-video-card-elementor' ),
                'label_off'    => __( 'Hide', 'wistia-video-card-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', 'wistia-video-card-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'My Wistia Video', 'wistia-video-card-elementor' ),
                'label_block' => true,
                'dynamic'     => [
                    'active' => true,
                ],
                'condition'   => [
                    'show_title' => 'yes',
                ],
            ]
        );

        // Description Toggle
        $this->add_control(
            'show_description',
            [
                'label'        => __( 'Show Description', 'wistia-video-card-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'wistia-video-card-elementor' ),
                'label_off'    => __( 'Hide', 'wistia-video-card-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'description',
            [
                'label'       => __( 'Description', 'wistia-video-card-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
                'placeholder' => __( 'Enter video description here...', 'wistia-video-card-elementor' ),
                'dynamic'     => [
                    'active' => true,
                ],
                'condition'   => [
                    'show_description' => 'yes',
                ],
            ]
        );

        // Layout Options
        $this->add_control(
            'content_position',
            [
                'label'       => __( 'Title & Description Position', 'wistia-video-card-elementor' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'above',
                'options'     => [
                    'above' => __( 'Above Video', 'wistia-video-card-elementor' ),
                    'below' => __( 'Below Video', 'wistia-video-card-elementor' ),
                ],
                'separator'   => 'before',
                'condition'   => [
                    'show_title'       => 'yes',
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_position',
            [
                'label'     => __( 'Title Position', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'above',
                'options'   => [
                    'above' => __( 'Above Video', 'wistia-video-card-elementor' ),
                    'below' => __( 'Below Video', 'wistia-video-card-elementor' ),
                ],
                'condition' => [
                    'show_title!' => '',
                    'show_description' => '',
                ],
            ]
        );

        $this->add_control(
            'description_position',
            [
                'label'     => __( 'Description Position', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'below',
                'options'   => [
                    'above' => __( 'Above Video', 'wistia-video-card-elementor' ),
                    'below' => __( 'Below Video', 'wistia-video-card-elementor' ),
                ],
                'condition' => [
                    'show_description!' => '',
                    'show_title' => '',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Video Settings Section ---
        $this->start_controls_section(
            'video_settings_section',
            [
                'label' => __( 'Video Settings', 'wistia-video-card-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'aspect_ratio',
            [
                'label'   => __( 'Aspect Ratio', 'wistia-video-card-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '16_9',
                'options' => [
                    '16_9' => '16:9',
                    '4_3'  => '4:3',
                    '3_2'  => '3:2',
                    '1_1'  => '1:1',
                    'custom' => __( 'Custom', 'wistia-video-card-elementor' ),
                ],
            ]
        );

        $this->add_responsive_control(
            'video_width',
            [
                'label'      => __( 'Video Width', 'wistia-video-card-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [
                        'min' => 200,
                        'max' => 1200,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .wistia-video-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'video_height',
            [
                'label'     => __( 'Video Height', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                        'step' => 10,
                    ],
                ],
                'default'   => [
                    'size' => 360,
                    'unit' => 'px',
                ],
                'condition' => [
                    'aspect_ratio' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Card Style Section ---
        $this->start_controls_section(
            'card_style_section',
            [
                'label' => __( 'Card Style', 'wistia-video-card-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label'     => __( 'Card Background', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wistia-video-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label'      => __( 'Card Padding', 'wistia-video-card-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wistia-video-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20',
                    'unit'   => 'px',
                ],
            ]
        );

        // Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'card_border',
                'label'    => __( 'Border', 'wistia-video-card-elementor' ),
                'selector' => '{{WRAPPER}} .wistia-video-card',
            ]
        );

        // Border Radius
        $this->add_responsive_control(
            'card_border_radius',
            [
                'label'      => __( 'Border Radius', 'wistia-video-card-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .wistia-video-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box Shadow
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_box_shadow',
                'label'    => __( 'Box Shadow', 'wistia-video-card-elementor' ),
                'selector' => '{{WRAPPER}} .wistia-video-card',
            ]
        );

        $this->end_controls_section();

        // --- Title Style Section ---
        $this->start_controls_section(
            'title_style_section',
            [
                'label'     => __( 'Title Style', 'wistia-video-card-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Title Color', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wistia-video-card .video-title' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .wistia-video-card .video-title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __( 'Title Margin', 'wistia-video-card-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wistia-video-card .video-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_text_align',
            [
                'label'     => __( 'Text Align', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'wistia-video-card-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'wistia-video-card-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'wistia-video-card-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wistia-video-card .video-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Description Style Section ---
        $this->start_controls_section(
            'description_style_section',
            [
                'label'     => __( 'Description Style', 'wistia-video-card-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __( 'Description Color', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wistia-video-card .video-description' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .wistia-video-card .video-description',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label'      => __( 'Description Margin', 'wistia-video-card-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wistia-video-card .video-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_text_align',
            [
                'label'     => __( 'Text Align', 'wistia-video-card-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'wistia-video-card-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'wistia-video-card-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'wistia-video-card-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'wistia-video-card-elementor' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wistia-video-card .video-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // --- Video Style Section ---
        $this->start_controls_section(
            'video_style_section',
            [
                'label' => __( 'Video Style', 'wistia-video-card-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_margin',
            [
                'label'      => __( 'Video Margin', 'wistia-video-card-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wistia-video-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_border_radius',
            [
                'label'      => __( 'Video Border Radius', 'wistia-video-card-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wistia-video-wrapper iframe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Extracts Wistia video ID from various formats.
     */
    private function get_wistia_id( $input ) {
        if ( empty( $input ) ) {
            return '';
        }

        // Remove any whitespace
        $input = trim( $input );

        // If just ID is entered (alphanumeric characters only)
        if ( preg_match( '/^[a-zA-Z0-9]+$/', $input ) ) {
            return $input;
        }

        // Match from share link: https://wistia.com/medias/abcd1234
        if ( preg_match( '/medias\/([a-zA-Z0-9]+)/', $input, $matches ) ) {
            return $matches[1];
        }

        // Match from embed link: https://fast.wistia.net/embed/iframe/abcd1234
        if ( preg_match( '/iframe\/([a-zA-Z0-9]+)/', $input, $matches ) ) {
            return $matches[1];
        }

        // Match from embed link: https://fast.wistia.net/embed/medias/abcd1234
        if ( preg_match( '/embed\/medias\/([a-zA-Z0-9]+)/', $input, $matches ) ) {
            return $matches[1];
        }

        // Match from player link: https://wistia.com/videos/abcd1234
        if ( preg_match( '/videos\/([a-zA-Z0-9]+)/', $input, $matches ) ) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Get aspect ratio padding
     */
    private function get_aspect_ratio_padding( $ratio ) {
        switch ( $ratio ) {
            case '16_9':
                return '56.25%'; // (9/16)*100
            case '4_3':
                return '75%';    // (3/4)*100
            case '3_2':
                return '66.67%'; // (2/3)*100
            case '1_1':
                return '100%';   // (1/1)*100
            default:
                return '56.25%'; // Default to 16:9
        }
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $video_input     = ! empty( $settings['video_url'] ) ? sanitize_text_field( $settings['video_url'] ) : '';
        $show_title      = $settings['show_title'] === 'yes';
        $show_description = $settings['show_description'] === 'yes';
        $title           = $show_title && ! empty( $settings['title'] ) ? $settings['title'] : '';
        $description     = $show_description && ! empty( $settings['description'] ) ? $settings['description'] : '';
        
        $aspect_ratio    = $settings['aspect_ratio'] ?? '16_9';
        $video_height    = ! empty( $settings['video_height']['size'] ) ? (int) $settings['video_height']['size'] : 360;
        
        // Position logic
        $content_position = $settings['content_position'] ?? 'above';
        $title_position = $settings['title_position'] ?? 'above';
        $description_position = $settings['description_position'] ?? 'below';
        
        // If both title and description are shown, use content_position
        if ( $show_title && $show_description ) {
            $title_position = $content_position;
            $description_position = $content_position;
        }

        $video_id   = $this->get_wistia_id( $video_input );
        $embed_url  = $video_id ? 'https://fast.wistia.net/embed/iframe/' . $video_id : '';

        ?>
        <div class="wistia-video-card">
            <?php
            // Render title above video
            if ( $title && $title_position === 'above' ) : ?>
                <h3 class="video-title"><?php echo wp_kses_post( $title ); ?></h3>
            <?php endif;

            // Render description above video
            if ( $description && $description_position === 'above' ) : ?>
                <p class="video-description"><?php echo wp_kses_post( $description ); ?></p>
            <?php endif; ?>

            <?php if ( $embed_url ) : ?>
                <div class="wistia-video-wrapper" style="position: relative; <?php echo $aspect_ratio === 'custom' ? 'height: ' . esc_attr( $video_height ) . 'px;' : 'padding-bottom: ' . esc_attr( $this->get_aspect_ratio_padding( $aspect_ratio ) ) . '; height: 0;'; ?> overflow: hidden;">
                    <iframe 
                        src="<?php echo esc_url( $embed_url ); ?>" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        frameborder="0" 
                        allowfullscreen>
                    </iframe>
                </div>
            <?php else : ?>
                <div class="wistia-video-error">
                    <p><?php echo esc_html__( 'Please enter a valid Wistia video URL or ID.', 'wistia-video-card-elementor' ); ?></p>
                </div>
            <?php endif;

            // Render title below video
            if ( $title && $title_position === 'below' ) : ?>
                <h3 class="video-title"><?php echo wp_kses_post( $title ); ?></h3>
            <?php endif;

            // Render description below video
            if ( $description && $description_position === 'below' ) : ?>
                <p class="video-description"><?php echo wp_kses_post( $description ); ?></p>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var show_title = settings.show_title === 'yes';
        var show_description = settings.show_description === 'yes';
        var title = show_title && settings.title ? settings.title : '';
        var description = show_description && settings.description ? settings.description : '';
        var video_input = settings.video_url ? settings.video_url.trim() : '';
        var aspect_ratio = settings.aspect_ratio || '16_9';
        var video_height = settings.video_height && settings.video_height.size ? settings.video_height.size : 360;
        
        // Position logic
        var content_position = settings.content_position || 'above';
        var title_position = settings.title_position || 'above';
        var description_position = settings.description_position || 'below';
        
        // If both title and description are shown, use content_position
        if ( show_title && show_description ) {
            title_position = content_position;
            description_position = content_position;
        }

        var video_id = '';

        // JS RegEx to extract ID
        if ( video_input.match(/^[a-zA-Z0-9]+$/) ) {
            video_id = video_input;
        } else if ( video_input.match(/medias\/([a-zA-Z0-9]+)/) ) {
            video_id = video_input.match(/medias\/([a-zA-Z0-9]+)/)[1];
        } else if ( video_input.match(/iframe\/([a-zA-Z0-9]+)/) ) {
            video_id = video_input.match(/iframe\/([a-zA-Z0-9]+)/)[1];
        } else if ( video_input.match(/embed\/medias\/([a-zA-Z0-9]+)/) ) {
            video_id = video_input.match(/embed\/medias\/([a-zA-Z0-9]+)/)[1];
        } else if ( video_input.match(/videos\/([a-zA-Z0-9]+)/) ) {
            video_id = video_input.match(/videos\/([a-zA-Z0-9]+)/)[1];
        }

        var embed_url = video_id ? 'https://fast.wistia.net/embed/iframe/' + video_id : '';
        
        // Aspect ratio function
        function getAspectRatioPadding(ratio) {
            switch (ratio) {
                case '16_9': return '56.25%';
                case '4_3': return '75%';
                case '3_2': return '66.67%';
                case '1_1': return '100%';
                default: return '56.25%';
            }
        }
        
        var paddingBottom = getAspectRatioPadding(aspect_ratio);
        #>

        <div class="wistia-video-card">
            <# if ( title && title_position === 'above' ) { #>
                <h3 class="video-title">{{{ title }}}</h3>
            <# } #>

            <# if ( description && description_position === 'above' ) { #>
                <p class="video-description">{{{ description }}}</p>
            <# } #>

            <# if ( embed_url ) { #>
                <div class="wistia-video-wrapper" style="position: relative; <# if ( aspect_ratio === 'custom' ) { #>height: {{ video_height }}px;<# } else { #>padding-bottom: {{ paddingBottom }}; height: 0;<# } #> overflow: hidden;">
                    <iframe 
                        src="{{ embed_url }}" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                        frameborder="0" 
                        allowfullscreen>
                    </iframe>
                </div>
            <# } else { #>
                <div class="wistia-video-error">
                    <p><?php echo esc_html__( 'Please enter a valid Wistia video URL or ID.', 'wistia-video-card-elementor' ); ?></p>
                </div>
            <# } #>

            <# if ( title && title_position === 'below' ) { #>
                <h3 class="video-title">{{{ title }}}</h3>
            <# } #>

            <# if ( description && description_position === 'below' ) { #>
                <p class="video-description">{{{ description }}}</p>
            <# } #>
        </div>
        <?php
    }
}