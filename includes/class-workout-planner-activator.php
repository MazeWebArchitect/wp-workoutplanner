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

		$maintable = Workout_Planner_Globals::main_table();
		$metatable = Workout_Planner_Globals::meta_table();

		$charset_collate = $wpdb->get_charset_collate();

		$sqlmain = "CREATE TABLE $maintable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  planname tinytext NOT NULL,
		  workoutday smallint NOT NULL,
		  totalworkoutweeks SMALLINT NOT NULL,
		  zoneintensity smallint,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		$sqlmeta = "CREATE TABLE $metatable (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  plannid mediumint(9) NOT NULL,
		  trainingzone text,
		  week tinyint NOT NULL,
		  exercise text NOT NULL,
		  description text NOT NULL,
		  quantity smallint NOT NULL,
		  repetitions smallint NOT NULL,
		  weightortime mediumint DEFAULT 0,
		  finished boolean DEFAULT false NOT NULL,
		  unfinishreason text,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sqlmain );
		dbDelta( $sqlmeta );

		add_option( 'workoutplanner_db_version', $workoutplanner_db_version );
	}

	public static function insert_dummy_data() {
		require_once plugin_dir_path( __FILE__ ) . 'class-workout-planner-globals.php';
		global $wpdb;

		/* Dummy Data for MAIN Table */
		$main_table = Workout_Planner_Globals::main_table();
		$planname = 'Upper-Body Day 1';
		$workoutday = 1;
		$totalworkoutweeks = 8;
		$zoneintesity = 4;

		$wpdb->insert(
			$main_table,
			array(
				'time' => current_time( 'mysql' ),
				'planname' => $planname,
				'workoutday' => $workoutday,
				'totalworkoutweeks' => $totalworkoutweeks,
				'zoneintensity' => $zoneintesity,
			)
		);

		/* Dummy Data for META Table */
		$meta_table = Workout_Planner_Globals::meta_table();
		$plannid = 1;
		$trainingzone = 'Upper Body';
		$week = 1;
		$exercise = 'Bench Press';
		$description = 'Slow and clean movements';
		$quantity = 5;
		$repetitions = 4;
		$weightortime = 35;
		$finished = false;
		$unfinishreason = 'Too hard';

		$wpdb->insert(
			$meta_table,
			array(
				'time' => current_time( 'mysql' ),
				'plannid' => $plannid,
				'trainingzone' => $trainingzone,
				'week' => $week,
				'exercise' => $exercise,
				'description' => $description,
				'quantity' => $quantity,
				'repetitions' => $repetitions,
				'weightortime' => $weightortime,
				'finished' => $finished,
				'unfinishreason' => $unfinishreason,
			)
		);
	}

}
