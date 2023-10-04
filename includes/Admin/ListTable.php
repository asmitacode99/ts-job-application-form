<?php
/**
 * Job Application Form Table List
 *
 * @version 1.0.0
 * @package  JobApplicationForm/ListTable
 */

namespace  JobApplicationForm\Admin;

defined( 'ABSPATH' ) || exit;

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Appications table list class.
 */
class ListTable extends \WP_List_Table {

	/**
	 * Initialize the Appications table list.
	 */
	public function __construct() {
		parent::__construct(
			array(
				'singular' => 'application',
				'plural'   => 'applications',
				'ajax'     => false,
			)
		);
	}

	/**
	 * Get applications columns.
	 *
	 * @return array
	 */
	public function get_columns(){
		$columns = array(
			'first_name' => esc_html__( 'First Name', 'ts-job-application-form' ),
			'last_name'  => esc_html__( 'Last Name', 'ts-job-application-form' ),
			'address'    => esc_html__( 'Address', 'ts-job-application-form' ),
			'email'      => esc_html__( 'Email', 'ts-job-application-form' ),
			'mobile'     => esc_html__( 'Mobile', 'ts-job-application-form' ),
			'post_name'  => esc_html__( 'Post Name', 'ts-job-application-form' ),
			'cv'         => esc_html__( 'CV', 'ts-job-application-form' ),
			'date'         => esc_html__( 'Date', 'ts-job-application-form' ),
		);

		return $columns;
	}

	/**
	 * Prepare table list items.
	*/
	public function prepare_items() {
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->items = $this->example_data;
	}

	/**
	 * Renders the columns.
	 *
	 * @param  object $application Application object.
	 * @param  string $column_name Column Name.
	 * @return string
	 */
	public function column_default( $application, $column_name ) {
		switch( $column_name ) {
			case 'first_name':
			case 'last_name':
			case 'address':
			case 'email':
			case 'mobile':
			case 'post_name':
			case 'cv':
			case 'date':
				return $application[ $column_name ];

			default:
			return print_r( $application, true ) ; //Show the whole array for troubleshooting purposes
		}
	}


	/**
	 * Get a list of sortable columns.
	 *
	 * @return array
	 */
	protected function get_sortable_columns() {
		$sortable_columns = array(
			'date' => array( 'date_created', false ),
		);

		return $sortable_columns;
	}


	/**
	 * Get bulk actions.
	 *
	 * @return array
	 */

	protected function get_bulk_actions() {
		$actions = array(
			'delete'    => esc_html__('Delete', 'ts-job-application-form' )
		);
		return $actions;
	}

	/**
	 * Render the list table page, including header, notices, status filters and table.
	 */
	public function display_page() {
		$this->prepare_items();
		?>
			<div class="wrap">
				<h1 class="wp-heading-inline"><?php esc_html_e( 'Job Applications' ); ?></h1>
				<hr class="wp-header-end">
				<form id="ts-job-application-list" method="get">
					<input type="hidden" name="page" value="ts-job-application" />
					<?php
						$this->views();
						$this->search_box( esc_html__( 'Search Applications', 'ts-job-application-form' ), 'application' );
						$this->display();

						wp_nonce_field( 'save', 'ts_job_application_list_nonce' );
					?>
				</form>
			</div>

		<?php
	}

}