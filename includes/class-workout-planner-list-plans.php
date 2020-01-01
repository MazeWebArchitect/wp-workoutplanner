<?php

/**
 * The overview of the created plans in the wp-admin backend
 *
 * This class selects all the created plans for the admin user.
 * It helps create the view 'workout-planner-admin-display.php'
 *
 * @since      1.0.0
 * @package    Workout_Planner
 * @subpackage Workout_Planner/includes
 * @author     Matthias Held <mazeme@gmail.com>
 */

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Workout_Planner_List_Plans extends WP_List_Table {

	public static function define_columns() {
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title', 'wp-workout-planner' ),
			'shortcode' => __( 'Shortcode', 'wp-workout-planner' ),
			'user_group' => __( 'User Group', 'wp-workout-planner' ),
			'author' => __( 'Author', 'wp-workout-planner' ),
			'date' => __( 'Date', 'wp-workout-planner' ),
		);

		return $columns;
	}

	public function __construct() {
		parent::__construct( array(
			'singular' => 'post',
			'plural' => 'posts',
			'ajax' => false,
		) );
	}

	public function prepare_items() {
		$current_screen = get_current_screen();

		$args = array(
			'posts_per_page' => 25,
			'orderby' => 'title',
			'order' => 'ASC',
			'offset' => ( $this->get_pagenum() - 1 ) * 25,
		);

		$this->items = WPCF7_ContactForm::find( $args );

		$total_items = WPCF7_ContactForm::count();
		$total_pages = ceil( $total_items / 25 );

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'total_pages' => $total_pages,
			'per_page' => 25,
		) );
	}

	public function get_columns() {
		return get_column_headers( get_current_screen() );
	}

	protected function get_sortable_columns() {
		$columns = array(
			'title' => array( 'title', true ),
			'author' => array( 'author', false ),
			'date' => array( 'date', false ),
		);

		return $columns;
	}

	protected function get_bulk_actions() {
		$actions = array(
			'delete' => __( 'Delete', 'wp-workout-planner'),
		);

		return $actions;
	}

	protected function column_default( $item, $column_name ) {
		return '';
	}

	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			$this->_args['singular'],
			$item->id()
		);
	}

	public function column_title( $item ) {
		$edit_link = add_query_arg(
			array(
				'post' => absint( $item->id() ),
				'action' => 'edit',
			),
			menu_page_url( 'wpcf7', false )
		);

		$output = sprintf(
			'<a class="row-title" href="%1$s" aria-label="%2$s">%3$s</a>',
			esc_url( $edit_link ),
			esc_attr( sprintf(
			/* translators: %s: title of contact form */
				__( 'Edit &#8220;%s&#8221;', 'wp-workout-planner' ),
				$item->title()
			) ),
			esc_html( $item->title() )
		);

		$output = sprintf( '<strong>%s</strong>', $output );

		return $output;
	}

	protected function handle_row_actions( $item, $column_name, $primary ) {
		if ( $column_name !== $primary ) {
			return '';
		}

		$edit_link = add_query_arg(
			array(
				'post' => absint( $item->id() ),
				'action' => 'edit',
			),
			menu_page_url( 'wpcf7', false )
		);

		$actions = array(
			'edit' => wpcf7_link( $edit_link, __( 'Edit', 'wp-workout-planner' ) ),
		);

		if ( current_user_can( 'wpcf7_edit_contact_form', $item->id() ) ) {
			$copy_link = add_query_arg(
				array(
					'post' => absint( $item->id() ),
					'action' => 'copy',
				),
				menu_page_url( 'wpcf7', false )
			);

			$copy_link = wp_nonce_url(
				$copy_link,
				'wpcf7-copy-contact-form_' . absint( $item->id() )
			);

			$actions = array_merge( $actions, array(
				'copy' => wpcf7_link( $copy_link, __( 'Duplicate', 'wp-workout-planner' ) ),
			) );
		}

		return $this->row_actions( $actions );
	}

	public function column_author( $item ) {
		$post = get_post( $item->id() );

		if ( ! $post ) {
			return;
		}

		$author = get_userdata( $post->post_author );

		if ( false === $author ) {
			return;
		}

		return esc_html( $author->display_name );
	}

	public function column_shortcode( $item ) {
		$shortcodes = array( $item->shortcode() );

		$output = '';

		foreach ( $shortcodes as $shortcode ) {
			$output .= "\n" . '<span class="shortcode"><input type="text"'
			           . ' onfocus="this.select();" readonly="readonly"'
			           . ' value="' . esc_attr( $shortcode ) . '"'
			           . ' class="large-text code" /></span>';
		}

		return trim( $output );
	}

	public function column_date( $item ) {
		$post = get_post( $item->id() );

		if ( ! $post ) {
			return;
		}

		$t_time = mysql2date( __( 'Y/m/d g:i:s A', 'wp-workout-planner' ),
			$post->post_date, true );
		$m_time = $post->post_date;
		$time = mysql2date( 'G', $post->post_date )
		        - get_option( 'gmt_offset' ) * 3600;

		$time_diff = time() - $time;

		if ( $time_diff > 0 and $time_diff < 24*60*60 ) {
			$h_time = sprintf(
			/* translators: %s: time since the creation of the plan*/
				__( '%s ago', 'wp-workout-planner' ),
				human_time_diff( $time )
			);
		} else {
			$h_time = mysql2date( __( 'Y/m/d', 'wp-workout-planner' ), $m_time );
		}

		return sprintf( '<abbr title="%2$s">%1$s</abbr>',
			esc_html( $h_time ),
			esc_attr( $t_time )
		);
	}
}
