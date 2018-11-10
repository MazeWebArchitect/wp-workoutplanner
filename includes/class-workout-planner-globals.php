<?php

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
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

}