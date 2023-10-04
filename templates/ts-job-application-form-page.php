<?php
/**
 * Job Application Form Layout
 *
 * @package JobApplicationForm/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<div class="ts-job-application-form-wrap">
	<div id="alerts-box"></div>

	<form id="ts-job-application-form" method="POST" enctype="multipart/form-data">
		<div class="ts-job-application-form-row">
			<div class="ts-job-application-form-input-row tsja">
				<label for="first_name" class="ts-job-application-form-label"><?php esc_html_e( 'First Name', 'ts-job-application-form' ); ?><span class="form-required">*</span></label>
				<input type="text" class="input-text ts-job-application-form-frontend-field" id="first_name" name="first_name" >
			</div>

			<div class="ts-job-application-form-input-row">
				<label for="last_name" class="ts-job-application-form-label"><?php esc_html_e( 'Last Name', 'ts-job-application-form' ); ?></label>
				<input type="text" class="input-text ts-job-application-form-frontend-field" id="last_name" name="last_name">
			</div>
		</div>

		<div class="ts-job-application-form-row">
			<div class="ts-job-application-form-input-row tsja">
				<label for="gender" class="ts-job-application-form-label"><?php esc_html_e( 'Gender', 'ts-job-application-form' ); ?><span class="form-required">*</span></label>
				<input type="radio" class="input-text ts-job-application-form-frontend-field" id="male" name="gender" value="Male" required>
				<label for="male"><?php esc_html_e( 'Male', 'ts-job-application-form' ); ?></label>

				<input type="radio" class="input-text ts-job-application-form-frontend-field" id="female" name="gender" value="Female" required>
				<label for="female"><?php esc_html_e( 'Female', 'ts-job-application-form' ); ?></label>

				<input type="radio" class="input-text ts-job-application-form-frontend-field" id="other" name="gender" value="Other" required>
				<label for="other"><?php esc_html_e( 'Other', 'ts-job-application-form' ); ?></label>
			</div>
		</div>

		<div class="ts-job-application-form-row">
			<div class="ts-job-application-form-input-row">
				<label for="user_email" class="ts-job-application-form-label"><?php esc_html_e( 'Email', 'ts-job-application-form' ); ?><span class="form-required">*</span></label>
				<input type="email" class="input-text ts-job-application-form-frontend-field" id="user_email" name="user_email" placeholder="<?php esc_html_e( 'example@example.com', 'ts-job-application-form' ); ?>" >
			</div>
			<div class="ts-job-application-form-input-row">
				<label for="user_phone" class="ts-job-application-form-label"><?php esc_html_e( 'Mobile No', 'ts-job-application-form' ); ?></label>
				<input type="tel" class="input-text ts-job-application-form-frontend-field" id="user_phone" name="user_phone" />
			</div>
		</div>

		<div class="ts-job-application-form-row">
			<div class="ts-job-application-form-input-row">
				<label for="user_address" class="ts-job-application-form-label"><?php esc_html_e( 'Current Address', 'ts-job-application-form' ); ?></label>
				<input type="text" class="input-text ts-job-application-form-frontend-field" id="user_address" name="user_address">
			</div>
		</div>

		<div class="ts-job-application-form-row">
			<div class="ts-job-application-form-input-row">
				<label for="post_name" class="ts-job-application-form-label"><?php esc_html_e( 'Applied Position', 'ts-job-application-form' ); ?><span class="form-required">*</span></label>
				<input type="text" class="input-text ts-job-application-form-frontend-field" id="post_name" name="post_name" placeholder="<?php esc_html_e( 'Senior Software Engineer', 'ts-job-application-form' ); ?>" >
			</div>
		</div>

		<div class="ts-job-application-form-row">
			<button type="submit" class="btn btn-primary" name="ts-job-application-form-submit" id="ts-job-application-form-submit-btn"><?php esc_html_e( 'Submit', 'ts-job-application-form' ); ?></button>
		</div>
	</form>
</div>
