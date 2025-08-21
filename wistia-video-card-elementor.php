<?php
/**
 * Plugin Name:       Wistia Video Card Elementor
 * Plugin URI:       https://github.com/umerirshad/wistia-video-card-elementor
 * Description:       Elementor widget to display Wistia videos in a customizable card layout.
 * Version:           1.0.0
 * Author:            Umer Irshad
 * Author URI:        https://github.com/umerirshad
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wistia-video-card-elementor
 * Domain Path:       /languages
 *
 * @package Wistia_Video_Card_Elementor
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define plugin constants.
 */
define( 'WISTIA_VIDEO_CARD_PLUGIN_VERSION', '1.0.0' );
define( 'WISTIA_VIDEO_CARD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WISTIA_VIDEO_CARD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/**
 * Check if Elementor is active
 */
function wistia_video_card_check_elementor() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'wistia_video_card_admin_notice_missing_elementor' );
        return false;
    }
    return true;
}

/**
 * Admin notice for missing Elementor
 */
function wistia_video_card_admin_notice_missing_elementor() {
    // Check if we're on the plugins page and just activated
    $screen = get_current_screen();
    if ( $screen && 'plugins' === $screen->id ) {
        // Remove the activation notice parameter to prevent showing it again
        if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            // This is just reading a URL parameter for display purposes, not processing form data
            wp_safe_redirect( remove_query_arg( 'activate' ) );
            exit;
        }
    }

    $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'wistia-video-card-elementor' ),
        '<strong>' . esc_html__( 'Wistia Video Card Elementor', 'wistia-video-card-elementor' ) . '</strong>',
        '<strong>' . esc_html__( 'Elementor', 'wistia-video-card-elementor' ) . '</strong>'
    );

    printf( 
        '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', 
        wp_kses( $message, [
            'strong' => [],
        ] ) 
    );
}

/**
 * Initialize the plugin
 */
function wistia_video_card_init() {
    // Check if Elementor is loaded
    if ( ! wistia_video_card_check_elementor() ) {
        return;
    }

    // Register widget only after Elementor is ready
    add_action( 'elementor/widgets/register', 'wistia_video_card_register_widget' );
}
add_action( 'plugins_loaded', 'wistia_video_card_init' );

/**
 * Register widget with Elementor
 */
function wistia_video_card_register_widget( $widgets_manager ) {
    // Include widget file only when needed
    require_once WISTIA_VIDEO_CARD_PLUGIN_DIR . 'includes/widget-wistia-video-card.php';
    
    // Register the widget
    $widgets_manager->register( new \WistiaVideoCardElementor\Widgets\Widget_Wistia_Video_Card() );
}