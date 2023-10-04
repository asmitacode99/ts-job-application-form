<?php
/**
 * Job_Application_Form setup
 *
 * @package Job_Application_Form
 * @since  1.0.0
 */

namespace JobApplicationForm;

use JobApplicationForm\Admin\Admin;
use JobApplicationForm\Shortcodes;
use JobApplicationForm\Ajax;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ApplicationForm' ) ) :

	/**
	 * Main ApplicationForm Class
	 *
	 * @class ApplicationForm
	 */
	final class ApplicationForm {

		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;

		/**
		 * Instance of Install Class.
		 *
		 * @since 1.0.0
		 *
		 */
		public $install = null;

		/**
		 * Admin class instance
		 *
		 * @var \Admin
		 * @since 1.0.0
		 */
		public $admin = null;

		// Day 2
		/**
		 * Shortcode class instance
		 *
		 * @var \Admin
		 * @since 1.0.0
		 */
		public $shortcodes = null;

		// Day 3
		/**
		 * Ajax.
		 *
		 * @since 1.0.0
		 *
		 * @var JobApplicationForm\Ajax;
		 */
		public $ajax = null;

		/**
		 * Return an instance of this class
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			require 'CoreFunctions.php';
			add_action( 'admin_notices', 'job_application_form_compatibility' );

			// Actions and Filters.
			add_filter( 'plugin_action_links_' . plugin_basename( TS_JOB_APPLICATION_FORM_PLUGIN_FILE ), array( $this, 'plugin_action_links' ) );
			add_action( 'init', array( $this, 'includes' ) );

			register_activation_hook( __FILE__, array( 'Install', 'install' ) );

		}

		/**
		 * Includes.
		 */
		public function includes() {
			// Files to include.
			$this->install = new Install();

			// Day 2
			$this->shortcodes = new Shortcodes();

			// Day 3
			$this->ajax = new Ajax();

			// Class admin.
			if ( $this->is_admin() ) {
				// require file.
				$this->admin = new Admin();
			}
		}

		/**
		 * Check if is admin or not and load the correct class
		 *
		 * @return bool
		 * @since 1.0.0
		 */
		public function is_admin() {
			$check_ajax    = defined( 'DOING_AJAX' ) && DOING_AJAX;
			$check_context = isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend';

			return is_admin() && ! ( $check_ajax && $check_context );
		}

		/**
		 * Display action links in the Plugins list table.
		 *
		 * @param array $actions Add plugin action link.
		 *
		 * @return array
		 */
		public function plugin_action_links( $actions ) {
			$new_actions = array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=job-application-form' ) . '" title="' . esc_attr( __( 'View Job Application Form Settings', 'ts-job-application-form' ) ) . '">' . __( 'Settings', 'ts-job-application-form' ) . '</a>',
			);

			return array_merge( $new_actions, $actions );
		}

		/**
		 * Get the plugin url.
		 *
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

	}
endif;

/**
 * Main instance of ApplicationForm.
 *
 * @since  1.0.0
 * @return ApplicationForm
 */
function ApplicationForm() {
	return ApplicationForm::get_instance();
}
