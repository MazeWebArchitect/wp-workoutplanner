<?php

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Workout_Planner
 * @subpackage Workout_Planner/includes
 * @author     Matthias Held <mazeme@gmail.com>
 */
class Workout_Planner_Deactivator {

	/**
	 * Delete all data associated with the plugin.
	 *
	 * Delete the Databasetables (Main and Meta)
	 * Also delete all the metadata in the wp_usermeta (workoutplanner_usergroup)
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		require_once plugin_dir_path( __FILE__ ) . 'class-workout-planner-globals.php';
		global $wpdb;
		$main_table = Workout_Planner_Globals::main_table();
		$meta_table = Workout_Planner_Globals::meta_table();
		$wp_user_meta_key = Workout_Planner_Globals::wp_user_meta_key();

		$sql = "DROP TABLE IF EXISTS $main_table, $meta_table";
		$wpdb->query($sql);
		delete_metadata('user', 0, $wp_user_meta_key, '', true);
		delete_option( 'workoutplanner_db_version' );

	}

}
