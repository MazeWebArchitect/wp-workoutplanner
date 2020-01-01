<?php
/**
* Checks if the necessary requirements are met.
*
* It checks for: WordPress version & PHP Version
*
* @link       workout-planner.de
* @since      1.0.0
*
* @package    Workout_Planner
* @subpackage Workout_Planner/admin/partials
*/

global $wp_version;

// Check for PHP version
if ( phpversion() < Workout_Planner_Globals::required_php_version() ) {
?>
    <div class="notice notice-warning">
	    <p>
		    <?php
		    echo sprintf(
			    __( '<strong>WP Workout Planner %1$s requires PHP %2$s or higher.</strong> 
                Please switch to PHP version %3$s .', 'workout-planner' ),
			    WP_WORKOUT_PLANNER_VERSION,
			    Workout_Planner_Globals::required_php_version(),
			    Workout_Planner_Globals::required_php_version()
		    );
		    ?>
	    </p>
	</div>
<?php
}

// Check for WordPress version
if ( $wp_version < Workout_Planner_Globals::required_wp_version()) {
?>
	<div class="notice notice-warning">
		<p>
			<?php
			echo sprintf(
				__( '<strong>WP Workout Planner %1$s requires WordPress %2$s or higher.</strong> 
                Please <a href="%3$s">update WordPress</a> first.', 'workout-planner' ),
				WP_WORKOUT_PLANNER_VERSION,
				Workout_Planner_Globals::required_wp_version(),
				admin_url( 'update-core.php' )
			);
			?>
		</p>
	</div>
<?php
}
