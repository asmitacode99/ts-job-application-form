<?php
/**
 * Dashboard widget for user activity.
 *
 * @package TSJOBApplicationForm/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
	<div class="ts-job-application-form-dashboard-widget-statictics">
		<ul>
			<li>
				<div class="ts-job-application-form-widget-title">
					<?php esc_html_e( 'Name', 'ts-job-application-form' ); ?>
				</div>
				<div class="ts-job-application-form-applicants-name">
				</div>
			</li>

			<li>
				<div class="ts-job-application-form-widget-title">
					<?php esc_html_e( 'Email', 'ts-job-application-form' ); ?>
				</div>
				<div class="ts-job-application-form-applicants-email">
				</div>
			</li>

			<li>
				<div class="ts-job-application-form-widget-title">
					<?php esc_html_e( 'Post Name', 'ts-job-application-form' ); ?>
				</div>
				<div class="ts-job-application-form-applicants-post-name">
				</div>
			</li>
		</ul>
	</div>
