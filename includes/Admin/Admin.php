<?php
/**
 * JobApplicationForm Admin.
 *
 * @class    Admin
 * @version  1.0.0
 * @package  JobApplicationForm/Admin
 */

namespace JobApplicationForm\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Class
 */
class Admin {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {

		$this->init_hooks();

		// Day 4 - Set screens.
		add_filter( 'set-screen-option', array( $this, 'set_screen_option' ), 10, 3 );

		add_action( 'wp_dashboard_setup', array( $this, 'ts_job_application_form_add_dashboard_widget' ) );

	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'job_application_form_menu' ), 68 );

		wp_register_style( 'ts-job-application-form-dashboard-widget-style', TS_JOB_APPLICATION_FORM_ASSETS_URL . '/css/ts-job-application-form-dashboard.css', array(), TS_JOB_APPLICATION_FORM_VERSION );
		wp_register_script( 'ts-job-application-form-dashboard-widget-js',TS_JOB_APPLICATION_FORM_ASSETS_URL . '/js/ts-job-application-form-dashboard.js', 'jquery', TS_JOB_APPLICATION_FORM_VERSION, false );
	}

	/**
	 * Add  menu item.
	 */
	public function job_application_form_menu() {
		$template_page = add_menu_page(
			__( 'Job Applications', 'ts-job-application-form' ),
			__( 'Job Applications', 'ts-job-application-form' ),
			'manage_options',
			'job-application-form',
			array(
				$this,
				'ts_job_application_form_list_page',
			), '', 56
		);

		add_action( 'load-' . $template_page, array( $this, 'template_page_init' ) );

	}

	/**
	 * Loads screen options into memory.
	 */
	public function template_page_init() {
		// Table display code here.

		
	}

	/**
	 *  Init the Job Application Form List page.
	 */
	public function ts_job_application_form_list_page() {
		 ob_start();
		 echo '<h1>Job Application Form Settings</h1>';
		 echo ob_get_clean();

		
	}

	/**
	 * Validate screen options on update.
	 *
	 * @param mixed $status Status.
	 * @param mixed $option Option.
	 * @param mixed $value Value.
	 */
	public function set_screen_option( $status, $option, $value ) {
		if ( in_array( $option, array( 'ts_job_applications_per_page' ), true ) ) {
			return $value;
		}

		return $status;
	}


	/**
	 * Register the applications dashboard widget.
	 *
	 */
	public function ts_job_application_form_add_dashboard_widget() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		wp_add_dashboard_widget( 'ts_job_application_form_latest_submissions', esc_html__( 'Latest Applications', 'ts-job-application-form' ), array( $this, 'ts_job_application_form_widget' ) );
	}

	/**
	 * Content to the ts_job_application_form_widget widget.
	 *
	 */
	public function ts_job_application_form_widget() {

		wp_enqueue_script( 'ts-job-application-form-dashboard-widget-js' );
		wp_enqueue_style( 'ts-job-application-form-dashboard-widget-style' );

		wp_localize_script(
			'ts-job-application-form-dashboard-widget-js',
			'ts_job_application_form_widget_params',
			array(
				'ajax_url'     => admin_url( 'admin-ajax.php' ),
				'loading'      => esc_html__( 'loading...', 'ts-job-application-form' ),
				'widget_nonce' => wp_create_nonce( 'dashboard-widget' ),
			)
		);

		include TS_JOB_APPLICATION_FORM_TEMPLATE_PATH . '/dashboard-widget.php';
	}
}