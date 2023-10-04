<?php
/**
 * JobApplicationForm AJAX
 *
 * AJAX Event Handler
 *
 * @class    AJAX
 * @version  1.0.0
 * @package  JobApplicationForm/Ajax
 * @category Class
 */

namespace  JobApplicationForm;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AJAX Class
 */
class AJAX {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		self::add_ajax_events();
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax)
	 */
	public static function add_ajax_events() {

		add_action( 'wp_ajax_ts_job_application_form_submit_form', array( __CLASS__, 'submit_form' ) );
		add_action('wp_ajax_nopriv_ts_job_application_form_submit_form', array( __CLASS__, 'submit_form' ) );

		add_action( 'wp_ajax_ts_job_application_form_dashboard_widget', array( __CLASS__, 'dashboard_widget' ) );
	}

	/**
	 * Handle form submit.
	 */
	public static function submit_form() {
		global $wpdb;

		if ( ! check_ajax_referer( 'ts_job_application_form_submit_nonce', 'security' ) ) {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Nonce error please reload.', 'ts-job-application-form' ),
				)
			);
		}

		$error_message = array();
		$applicant_data = array();

		if ( isset( $_POST['first_name'] ) && '' !== $_POST['first_name'] ) {
			$applicant_data['first_name'] = sanitize_text_field( $_POST['first_name'] );
		} else {
			$error_message['first_name_error'] = esc_html__( 'First Name field is required', 'ts-job-application-form' );
		}

		if ( isset( $_POST['user_email'] ) && '' !== $_POST['user_email'] ) {
			$applicant_data['email'] = sanitize_text_field( $_POST['user_email'] );
		} else {
			$error_message['user_email_error'] = esc_html__( 'Email field is required', 'ts-job-application-form' );
		}

		if ( isset( $_POST['post_name'] ) && '' !== $_POST['post_name'] ) {
			$applicant_data['post_name'] = sanitize_text_field( $_POST['post_name'] );
		} else {
			$error_message['post_name_error'] = esc_html__( 'Post Name Field is required', 'ts-job-application-form' );
		}

		if ( isset( $_POST['last_name'] ) && '' !== $_POST['last_name'] ) {
			$applicant_data['last_name'] = sanitize_text_field( $_POST['last_name'] );
		}

		if ( isset( $_POST['user_phone'] ) && '' !== $_POST['user_phone'] ) {
			$pattern = '/^(?:\+?\d{1,4}[\s-]*)?(?:\(\d{1,}\)|\d{1,})[\s-]*\d{1,}[\s-]*\d{1,}[\s-]*\d{1,}[\s-]*\d{1,}$/';

   			if ( preg_match( $pattern, $_POST['user_phone'] ) ) {
				$applicant_data['phone'] = sanitize_text_field( $_POST['user_phone'] );
			} else {
				$error_message['user_phone_error'] = esc_html__( 'Please enter a valid phone number.', 'ts-job-application-form' );
			}
		}

		if ( isset( $_POST['user_address'] ) && '' !== $_POST['user_address'] ) {
			$applicant_data['address'] = sanitize_text_field( $_POST['user_address'] );
		}

		$applicant_data['submitted_at'] = current_datetime()->format( 'Y-m-d H:i:s' );

		// Day 5
		if ( isset( $_FILES['user_file'] ) && $_FILES['user_file']['error'] === UPLOAD_ERR_OK ) {
			$file = $_FILES['user_file'];

			$upload_dir = wp_upload_dir();
			$target_dir = $upload_dir['path'];
			$target_file = $target_dir . '/' . basename($file['name']);

			if ( move_uploaded_file($file['tmp_name'], $target_file) ) {
				$applicant_data['cv'] = $upload_dir['url'] . '/' . basename($file['name']);
			} else {
				$error_message['user_file'] = esc_html__( 'Error uploading file.', 'ts-job-application-form' );
			}
		} else {
			$error_message['user_file'] = esc_html__( 'Upload CV is a required field.', 'ts-job-application-form' );
		}


		if ( ! empty( $error_message ) ) {
			wp_send_json_error( array( 'field_error' => $error_message ) );
		}

		$query_success = $wpdb->insert( 'wp_job_application_form', $applicant_data );

		if ( $query_success ) {
			$fullname = $applicant_data['first_name'] . ' ' . $applicant_data['last_name'];

			//  Leave an action hook for after application submission.
			do_action( 'ts_job_application_form_after_application_submission', $applicant_data['email'], $fullname );

			wp_send_json_success(
				array(
					'message' => esc_html__( 'Application Submitted Successfully', 'ts-job-application-form' )
				)
			);
		} else {
			wp_send_json_error(
				array(
					'message' => esc_html__( 'Application cannot be submitted at this moment. Please try again some time later', 'ts-job-application-form' )
				)
			);
		}
	}


	/**
	 * Dashboard Widget data.
	 *
	 */
	public static function dashboard_widget() {
		global $wpdb;

		check_ajax_referer( 'dashboard-widget', 'security' );

		$sql = "SELECT * FROM {$wpdb->prefix}job_application_form ORDER BY submitted_at DESC LIMIT 5";
		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		wp_send_json_success(
			array(
				'applications'       => $result,
			)
		); // WPCS: XSS OK.
	}

}
