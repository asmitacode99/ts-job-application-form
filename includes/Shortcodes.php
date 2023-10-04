<?php
/**
 *  Shortcodes.
 *
 * @class    Shortcodes
 * @version  1.0.0
 * @package  JobApplicationForm/Classes
 */

namespace  JobApplicationForm;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shortcodes Class
 */
class Shortcodes {

	/**
	 * Init Shortcodes.
	 */
	public function __construct() {
		$shortcodes = array(
			'job_application_form'        => __CLASS__ . '::job_application_form',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
	}

	/**
	 * Application Form shortcode.
	 *
	 * @param mixed $atts Attributes.
	 */
	public static function job_application_form( $atts ) {

		ob_start();
		self::render_application_form();
		return ob_get_clean();
	}

	/**
	 * Output for Application Form.
	 *
	 * @since 1.0.0
	 */
	public static function render_application_form() {
		// Day 2
		/**
		 * Enqueue the frontend form style.
		 */
		wp_enqueue_style( "ts-job-application-form-style", TS_JOB_APPLICATION_FORM_ASSETS_URL . '/css/ts-job-application-form.css', array(), TS_JOB_APPLICATION_FORM_VERSION );

		// Day 3
		/**
		 * Enqueue the frontend form script.
		 */
		wp_enqueue_script( "ts-job-application-form-script", TS_JOB_APPLICATION_FORM_ASSETS_URL . '/js/ts-job-application-form.js', array( 'jquery' ), TS_JOB_APPLICATION_FORM_VERSION );

		/**
		 * Localize parameters to be used in the script.
		 */
		wp_localize_script(
			"ts-job-application-form-script",
			"ts_job_application_form_script_params",
			array(
				'ajax_url'                              => admin_url( 'admin-ajax.php' ),
				'ts_job_application_form_submit_nonce' => wp_create_nonce( 'ts_job_application_form_submit_nonce' ),
				'ts_job_application_form_submit_button_text' => esc_html__( 'Submit', 'ts-job-application-form'),
				'ts_job_application_form_submitting_button_text' => esc_html__( 'Submitting ...', 'ts-job-application-form')
				)
			);

		if ( is_user_logged_in() ) {
			include TS_JOB_APPLICATION_FORM_TEMPLATE_PATH . '/ts-job-application-form-page.php';
		}
	}

}
