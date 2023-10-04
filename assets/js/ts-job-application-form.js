/* global  ts_job_application_form_script_params  */
jQuery(document).ready(function ($) {
  // Submit application when form is submitted.
  $("#ts-job-application-form").on("submit", function (e) {
    e.preventDefault();
    e.stopPropagation();

    $("#alerts-box").html("");
    $(".ts-job-application-form-error").remove();

    var formData = new FormData(this);
    formData.append("action", "ts_job_application_form_submit_form");
    formData.append(
      "security",
      ts_job_application_form_script_params.ts_job_application_form_submit_nonce
    );

    $.ajax({
      url: ts_job_application_form_script_params.ajax_url,
      data: formData,
      type: "POST",
      contentType: false,
      processData: false,
      beforeSend: function () {
        $("#ts-job-application-form-submit-btn")
          .html(
            ts_job_application_form_script_params.ts_job_application_form_submitting_button_text
          )
          .prop("disabled", true);
      },
      success: function (response) {
        if (response.success) {
          $("#alerts-box").html(
            $("#alerts-box").html() +
              "<div class='ts-job-application-form-success'>" +
              response.data.message +
              "</div>"
          );

          $("#ts-job-application-form").each(function () {
            this.reset();
          });
        } else {
          if (response.data.field_error) {
            Object.keys(response.data.field_error).map((field_key) => {
              $("#" + field_key.split("_error")[0])
                .closest(".ts-job-application-form-input-row")
                .append(
                  '<label class="ts-job-application-form-error" for="' +
                    field_key.split("_error")[0] +
                    '">' +
                    response.data.field_error[field_key] +
                    "</label>"
                );
            });
          } else {
            $("#alerts-box").html(
              $("#alerts-box").html() +
                "<div class='ts-job-application-form-error'>" +
                response.data.message +
                "</div>"
            );
          }
        }

        $("#ts-job-application-form-submit-btn")
          .html(
            ts_job_application_form_script_params.ts_job_application_form_submit_button_text
          )
          .prop("disabled", false);

        $(window).scrollTop(
          $(document)
            .find(".ts-job-application-form-wrap")
            .find(
              ".ts-job-application-form-success, .ts-job-application-form-error"
            )
            .offset().top
        );
      },
    });
  });
});
