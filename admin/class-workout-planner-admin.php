<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Workout_Planner
 * @subpackage Workout_Planner/admin
 * @author     Matthias Held <mazeme@gmail.com>
 */
class Workout_Planner_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/workout-planner-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/workout-planner-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register any menu pages used by the plugin.
	 * @since  1.0.0
	 * @access public
	 */
	public function wp_workout_planner_menu_pages() {

		add_menu_page (
			__( 'Manage the Workout Planner', 'wp-workout-planner' ),
			__( 'Workout Planner', 'wp-workout-planner' ),
			'manage_options',
			WP_WORKOUT_PLANNER_PATH. 'admin/partials/workout-planner-admin-display.php',
			'',
			'',
			26 // After the "Comments" section
		);

		add_action( 'admin_menu', 'wp_workout_planner_menu_pages' );

	}

}
