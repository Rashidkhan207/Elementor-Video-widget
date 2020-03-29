<?php
/**
 * Plugin Name: Polaris Media Elementor video widget
 * Description: Polaris Media Elementor video widget plugin for custom Video Player.
 * Plugin URI:  https://bscs-projects.blogspot.com/
 * Version:     1.0.0
 * Author:      khan
 * Author URI:  https://bscs-projects.blogspot.com/
 * Text Domain: polaris-media-elementor-video-widget
 */
 
if (!defined('ABSPATH')) {
    exit;
}
 // Exit if accessed directly

define( 'POLARIS_URI', plugins_url('', __FILE__) );
define( 'POLARIS_DIR', dirname( __FILE__ ) );
/**
 * Main Elementor widget Class
 *
 * The init class that runs the Elementor widget plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.0.0
 */

use \Elementor\Plugin as Plugin;
if( !class_exists('POLARIS_Elementor_Init') ){
	class POLARIS_Elementor_Init {
 
  /**
   * Plugin Version
   *
   * @since 1.0.0
   * @var string The plugin version.
   */
  const VERSION = '1.0.0';
 
  /**
   * Minimum Elementor Version
   *
   * @since 1.0.0
   * @var string Minimum Elementor version required to run the plugin.
   */
  const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
 
  /**
   * Minimum PHP Version
   *
   * @since 1.0.0
   * @var string Minimum PHP version required to run the plugin.
   */
  const MINIMUM_PHP_VERSION = '7.0';
        
  private static $_instance = null;
        public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;

		}
 
  /**
   * Constructor
   *
   * @since 1.0.0
   * @access public
   */
 public function __construct() {
			add_action( 'plugins_loaded', [ $this, 'init' ] );
		}

		public function init() {

			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );

				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );

				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			}

			// load text domain
			//load_plugin_textdomain( 'polaris', false, POLARIS_DIR . '/languages/' );

			add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

			add_action( "elementor/frontend/after_enqueue_styles", [ $this, 'widget_styles' ] );
			add_action( "elementor/frontend/after_register_scripts" , [ $this, 'widget_scripts' ] );

		}

		// widget styles
		function widget_styles() {
			wp_enqueue_style( "plyr", POLARIS_URI . '/assets/css/player-style.css' );
		}

		// widget scripts
		function widget_scripts() {
			wp_register_script( "plyr", POLARIS_URI. '/assets/js/plyr.js', array( 'jquery' ), self::VERSION, true );
			wp_register_script( "plyr-polyfilled", POLARIS_URI. '/assets/js/player.polyfilled.min.js', array( 'jquery' ), self::VERSION, true );
			wp_register_script( "polaris-main", POLARIS_URI. '/assets/js/widget-player.js', array( 'jquery' ), self::VERSION, true );
		}

		// initialize widgets
		public function init_widgets() {
			require_once( POLARIS_DIR . '/widgets/vid-player.php' );

			// Register widget
			Plugin::instance()->widgets_manager->register_widget_type( new \POLARIS_Video_Player() );
		}


		public function admin_notice_minimum_php_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 5: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'polaris' ),
				'<strong>' . esc_html__( 'Polaris Video Player For Elementor', 'polaris' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'polaris' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}

		public function admin_notice_minimum_elementor_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'polaris' ),
				'<strong>' . esc_html__( 'Polaris Video Player For Elementor', 'polaris' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'polaris' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}
 
		public function admin_notice_missing_main_plugin() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'polaris' ),
				'<strong>' . esc_html__( 'Polaris Video Player For Elementor', 'polaris' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'polaris' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );


		}

	}
	
	POLARIS_Elementor_Init::instance();
}
