<?php
/**
 * Plugin Name: Job Application Form Day 5
 * Plugin URI: https://wprdpress.org/plugins
 * Description: Job Application Form Plugin For WordPress.
 * Version: 1.0.0
 * Author: Prajjwal Poudel
 * Author URI: http://prajjwalpoudel.com.np
 * Text Domain: ts-job-application-form
 * Domain Path: /languages/
 *
 * Copyright: © 2022 Prajjwal.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package Job_Application_Form
 */

/* It prevents public user to directly access your .php files through URL.
   If your file contains some I/O operations it can eventually be triggered (by an attacker)
   and this might cause unexpected behavior.
   */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}else{

	?>
	<div class="notice notice-error">
		<p>
			<?php
				echo __( 'Please add vendor file </strong> using composer to use <strong>Job Application Form</strong> Plugin.', 'ts-job-application-form' );
			?>
		</p>
	</div>
<?php

}

use JobApplicationForm\ApplicationForm;

/* Define the plugin version constant.
   It will be used throughout the plugin when needed
   */
if ( ! defined( 'TS_JOB_APPLICATION_FORM_VERSION' ) ) {
	define( 'TS_JOB_APPLICATION_FORM_VERSION', '1.0.0' );
}

// Define constant that provides full path and name of the current file ( plugin's main file in this case ).
if ( ! defined( 'TS_JOB_APPLICATION_FORM_PLUGIN_FILE' ) ) {
	define( 'TS_JOB_APPLICATION_FORM_PLUGIN_FILE', __FILE__ );
}

// Day 2

// Define constant that provides url of the current directory where current file resides.
if ( ! defined( 'TS_JOB_APPLICATION_FORM_URL' ) ) {
	define( 'TS_JOB_APPLICATION_FORM_URL', plugin_dir_url( __FILE__ ) );
}

// Define constant that provides the url to the assets file which contains js, css and images file need for the plugin.
if ( ! defined( 'TS_JOB_APPLICATION_FORM_ASSETS_URL' ) ) {
	define( 'TS_JOB_APPLICATION_FORM_ASSETS_URL', TS_JOB_APPLICATION_FORM_URL . 'assets' );
}

// Define constant that provides full path of the current directory where current file resides.
if ( ! defined( 'TS_JOB_APPLICATION_FORM_DIR' ) ) {
	define( 'TS_JOB_APPLICATION_FORM_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( ' TS_JOB_APPLICATION_FORM_TEMPLATE_PATH' ) ) {
	define( 'TS_JOB_APPLICATION_FORM_TEMPLATE_PATH', TS_JOB_APPLICATION_FORM_DIR . 'templates' );
}

/**
 * Initialization of ApplicationForm instance.
 **/
function job_application_form() {
	return ApplicationForm::get_instance();
}

job_application_form();
