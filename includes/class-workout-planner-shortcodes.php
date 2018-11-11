<?php

/**
 * Register shortcodes for the Workout-Planner
 *
 * @since    1.0.0
 */

add_action('init', 'workout_planner_shortcodes_init');

function workout_planner_shortcodes_init() {

    /**
     * Register the Shortcode for displaying a workout plan
     *
     * @since    1.0.0
     */
    function display_workout_plan($atts) {
        global $wpdb;
        $maintable = $wpdb->prefix . "workoutplanner_plans";
        $metatable = $wpdb->prefix . "workoutplanner_plan_meta";
        $db_planname = 'planname';
        $db_workoutday = 'workoutday';


        $atts = shortcode_atts(array(
            'id' => '1',
            'planname' => 'My WorkOut',
            'daylabel' => 'plain',
            'workoutday' => '1',
            'totalworkoutweeks' => '8',
            'zoneintensity' => '4',
            'metaid' => '1',
            'plan_id' => '1',
            'trainingzones' => 'Upper Body',
            'week' => '1',
            'excercise' => 'Bench Press',
            'description' => 'JUST.DO.IT',
            'quantity' => '5',
            'repetitions' => '4',
            'weightortime' => '35',
            'finished' => '0',
            'unfinishreason' => 'too hard',
        ),
            $atts,
            'workout-plan'
        );
        $planid = esc_attr($atts['id']);
        $planname = $wpdb->get_var("SELECT $db_planname FROM $maintable WHERE `id` = $planid");
        $workoutday = $wpdb->get_var("SELECT $db_workoutday FROM $maintable WHERE `id` = $planid");
        if ($atts['daylabel'] == 'plain') {
            $daylabel = array(
                '1' => __('Mon', 'workout-plan'),
                '2' => __('Tue', 'workout-plan'),
                '3' => __('Wen', 'workout-plan'),
                '4' => __('Thu', 'workout-plan'),
                '5' => __('Fri', 'workout-plan'),
                '6' => __('Sat', 'workout-plan'),
                '7' => __('Sun', 'workout-plan'),
            );
            $day = $daylabel[$workoutday];
        }
        else {
            $day = $workoutday;
        }

        $plan = __('Day ', 'workout-plan');
        $plan .= $planid;



        $html = '
            <div>
               <h2 class="uppercase">' . $plan . '</h2>
               ' . $planname . '<br>
               ' . $day . '
            </div>
        ';

        return $html;
    }

    add_shortcode('workout-plan', 'display_workout_plan');
}
