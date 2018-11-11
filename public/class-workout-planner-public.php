<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Workout_Planner
 * @subpackage Workout_Planner/public
 * @author     Matthias Held <mazeme@gmail.com>
 */
class Workout_Planner_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 * Main Style = All plugin specific custom styles
     * PureCSS = Grid-template from https://purecss.io/
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

        wp_register_style( $this->plugin_name . '-main-style', plugin_dir_url( __FILE__ ) . 'css/workout-planner-public.css', array(), $this->version, 'all' );
        wp_register_style( $this->plugin_name . '-purecss-base', plugin_dir_url( __FILE__ ) . 'css/inc/purecss/base-min.css', array(), $this->version, 'all' );
        wp_register_style( $this->plugin_name . '-purecss-grids', plugin_dir_url( __FILE__ ) . 'css/inc/purecss/grids-min.css', array(), $this->version, 'all' );
        wp_register_style( $this->plugin_name . '-purecss-grids-resp', plugin_dir_url( __FILE__ ) . 'css/inc/purecss/grids-responsive-min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name . '-main-style' );
        wp_enqueue_style( $this->plugin_name . '-purecss-base' );
        wp_enqueue_style( $this->plugin_name . '-purecss-grids' );
        wp_enqueue_style( $this->plugin_name . '-purecss-grids-resp' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/workout-planner-public.js', array( 'jquery' ), $this->version, false );

	}

}
