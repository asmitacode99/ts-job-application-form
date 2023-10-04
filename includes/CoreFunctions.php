<?php
/**
 * JobApplicationForm CoreFunctions.
 *
 * General core functions available on both the front-end and admin.
 *
 * @author   Prajjwal
 * @category Core
 * @version  1.0.0
 */

if ( ! function_exists( 'job_application_form_compatibility' ) ) {

	/**
	 * Check if the plugin is compatible with the current site's PHP and WordPress Version
	 *
	 */
	function job_application_form_compatibility() {
		global $wp_version;
		$message = '';

		ob_start();
		if ( version_compare( phpversion(), '8.1.9', '<' ) ) {
			?>
			<div class="notice notice-error">
				<p>
					<?php
						echo __( 'Please update your <strong>PHP</strong> version to at least 8.3 version to use <strong>Job Application Form</strong> Plugin.', 'ts-job-application-form' );
					?>
				</p>
			</div>
			<?php
		}

		if ( version_compare( $wp_version, '6.3.1', '<' ) ) {
			?>
			<div class="notice notice-error">
				<p>
					<?php
						echo __( 'Please update your <strong>WordPress</strong> version to at least 6.3.2 version to use <strong>Job Application Form</strong> Plugin.', 'ts-job-application-form' );
					?>
				</p>
			</div>
			<?php
		}
		$message = ob_get_clean();

		echo wp_kses_post( $message );
	}
}
