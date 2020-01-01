<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Workout_Planner
 * @subpackage Workout_Planner/includes
 * @author     Matthias Held <mazeme@gmail.com>
 */
class Workout_Planner_Activator {

	/**
	 * Add the neccesary database tables and installs dummy data.
	 *
	 * Adds the main table and meta table for the workout planner
	 * Also adds some dummy data for the user to see how it works
	 *
	 * @since    1.0.0
	 */

	public static function activate() {
		require_once plugin_dir_path( __FILE__ ) . 'class-workout-planner-globals.php';
		global $wpdb;
		global $workoutplanner_db_version;

		$workoutplanner_db_version = Workout_Planner_Globals::database_version();
        add_option( 'workoutplanner_db_version', $workoutplanner_db_version );

		$maintable = Workout_Planner_Globals::main_table();
		$metatable = Workout_Planner_Globals::meta_table();

		$charset_collate = $wpdb->get_charset_collate();

		$sqlmain = "CREATE TABLE $maintable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  fk_user int,
		  wp_user_group int,
		  plan_name tinytext NOT NULL,
		  total_workout_weeks smallint,
		  focus_zones smallint,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		$sqlmeta = "CREATE TABLE $metatable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  fk_plan_id mediumint(9) NOT NULL,
		  training_zone text,
		  workout_day tinyint,
		  week tinyint NOT NULL,
		  exercise text NOT NULL,
		  description text NOT NULL,
		  quantity smallint NOT NULL,
		  repetitions smallint NOT NULL,
		  weight_or_time mediumint DEFAULT 0,
		  finished boolean DEFAULT false NOT NULL,
		  reason_not_finishing text,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( [$sqlmain, $sqlmeta] );

	}

	public static function insert_dummy_data() {
		require_once plugin_dir_path( __FILE__ ) . 'class-workout-planner-globals.php';
		global $wpdb;

		/* Dummy Data for MAIN Table */
		$main_table = Workout_Planner_Globals::main_table();
		$plan_name = 'Upper-Body Day 1';
		$total_workout_weeks = 8;
		$focus_zones = 4;

		$wpdb->insert(
			$main_table,
			array(
				'time' => current_time( 'mysql' ),
				'fk_user' => null,
				'plan_name' => $plan_name,
				'total_workout_weeks' => $total_workout_weeks,
				'focus_zones' => $focus_zones,
			)
		);

		/* Dummy Data for META Table */
		$meta_table = Workout_Planner_Globals::meta_table();
		$plan_id = 1;
		$training_zone = 'Upper Body';
		$workout_day = 3;
		$week = 1;
		$exercise = 'Bench Press';
		$description = 'Slow and clean movements';
		$quantity = 5;
		$repetitions = 4;
		$weight_or_time = 35;
		$finished = false;
		$reason_not_finishing = 'Too hard';

		$wpdb->insert(
			$meta_table,
			array(
				'time' => current_time( 'mysql' ),
				'fk_plan_id' => $plan_id,
				'training_zone' => $training_zone,
				'workout_day' => $workout_day,
				'week' => $week,
				'exercise' => $exercise,
				'description' => $description,
				'quantity' => $quantity,
				'repetitions' => $repetitions,
				'weight_or_time' => $weight_or_time,
				'finished' => $finished,
				'reason_not_finishing' => $reason_not_finishing,
			)
		);

	}

}
