<?php

/**
 * Global Parameters that are used in the plugin.
 */
class Workout_Planner_Globals {

	public static function database_version() {
		return '1.0';
	}

	public static function main_table() {
		global $wpdb;
		return $workoutplanner_main_table = $wpdb->prefix . "workoutplanner_plans";
	}

	public static function meta_table() {
		global $wpdb;
		return $workoutplanner_meta_table = $wpdb->prefix . "workoutplanner_plan_meta";
	}

	public static function wp_user_meta_key() {
		return "workoutplanner_usergroup";
	}

}