<?php

/**
 * WorkOut Planner
 *
 * @link              workout-planner.de
 * @since             1.0.0
 * @package           Workout_Planner
 *
 * @wordpress-plugin
 * Plugin Name:       WorkOut Planner
 * Plugin URI:        workout-planner.de
 * Description:       Plan and execute your workouts with this plugin.
 * Version:           1.0.0
 * Author:            Matthias Held
 * Author URI:        workout-planner.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       workout-planner
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-workout-planner-activator.php
 */
function activate_workout_planner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-workout-planner-activator.php';
	Workout_Planner_Activator::activate();
	Workout_Planner_Activator::insert_dummy_data();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-workout-planner-deactivator.php
 */
function deactivate_workout_planner() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-workout-planner-deactivator.php';
	Workout_Planner_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_workout_planner' );
register_deactivation_hook( __FILE__, 'deactivate_workout_planner' );

/**
 * Define and register all shortcodes used by the plugin.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-workout-planner-shortcodes.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-workout-planner.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_workout_planner() {

	define( 'WP_WORKOUT_PLANNER_FILE', __FILE__ );

	// Defines the path to be used for includes
	define( 'WP_WORKOUT_PLANNER_PATH', plugin_dir_path( WP_WORKOUT_PLANNER_FILE ) );

	// Defines the URL to the plugin
	define( 'WP_WORKOUT_PLANNER_URL', plugin_dir_url( WP_WORKOUT_PLANNER_FILE ) );

	// Defines the current version of the plugin
	define( 'WP_WORKOUT_PLANNER_VERSION', '1.0.0' );

	$plugin = new Workout_Planner();
	$plugin->run();


}
run_workout_planner();
