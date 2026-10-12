/**
 * Formula Deactivation Feedback Scripts
 *
 * Handles the deactivation feedback modal on themes page.
 *
 * @package formula
 */

(function ($) {
    'use strict';

    var modal = null;
    var pendingActivationUrl = null;

    $(document).ready(function () {
        modal = $('#formula-deactivation-modal');

        if (!modal.length) {
            return;
        }

        // Intercept theme activation clicks.
        interceptThemeActivation();

        // Handle modal close.
        modal.on('click', '.formula-deactivation-close', closeModal);

        // Close on overlay click.
        modal.on('click', function (e) {
            if ($(e.target).hasClass('formula-deactivation-overlay')) {
                closeModal();
            }
        });

        // Close on Escape key.
        $(document).on('keyup', function (e) {
            if (e.key === 'Escape' && modal.is(':visible')) {
                closeModal();
            }
        });

        // Show additional feedback textarea when reason is selected.
        $('input[name="deactivation_reason"]').on('change', function () {
            var detailsBox = $('.formula-feedback-details');
            var selectedValue = $(this).val();

            // Show textarea for all options except 'temporary'.
            if (selectedValue && selectedValue !== 'temporary') {
                detailsBox.slideDown(150);
            } else {
                detailsBox.slideUp(150);
            }
        });

        // Handle skip button.
        modal.on('click', '.formula-skip-btn', function () {
            proceedWithDeactivation();
        });

        // Handle submit button.
        modal.on('click', '.formula-submit-btn', function () {
            submitFeedback();
        });
    });

    /**
     * Intercept clicks on theme activation buttons.
     */
    function interceptThemeActivation() {
        // For theme cards — intercept the Activate button.
        $(document).on('click', '.theme-actions .activate', function (e) {
            var activationUrl = $(this).attr('href');

            if (activationUrl && activationUrl.indexOf('action=activate') !== -1) {
                e.preventDefault();
                pendingActivationUrl = activationUrl;
                $('#formula-new-theme-url').val(activationUrl);
                showModal();
            }
        });

        // For theme overlay — intercept the Activate button.
        $(document).on('click', '.theme-overlay .theme-actions .activate', function (e) {
            var activationUrl = $(this).attr('href');

            if (activationUrl && activationUrl.indexOf('action=activate') !== -1) {
                e.preventDefault();
                pendingActivationUrl = activationUrl;
                $('#formula-new-theme-url').val(activationUrl);
                showModal();
            }
        });
    }

    /**
     * Show the modal.
     */
    function showModal() {
        modal.fadeIn(100);
        $('body').addClass('formula-modal-open');

        // Reset form.
        $('#formula-deactivation-form')[0].reset();
        $('.formula-feedback-details').hide();
    }

    /**
     * Close the modal.
     */
    function closeModal() {
        modal.fadeOut(100);
        $('body').removeClass('formula-modal-open');
        pendingActivationUrl = null;
    }

    /**
     * Submit feedback and proceed with deactivation.
     */
    function submitFeedback() {
        var reason = $('input[name="deactivation_reason"]:checked').val();
        var feedback = $('#formula-feedback-text').val();

        // Require a reason to be selected.
        if (!reason) {
            alert(wp.i18n ? wp.i18n.__('Please select a reason for deactivating.', 'formula') : 'Please select a reason for deactivating.');
            return;
        }

        var $submitBtn = modal.find('.formula-submit-btn');
        $submitBtn.prop('disabled', true).text('Submitting...');

        $.ajax({
            url: formulaDeactivation.ajaxurl,
            type: 'POST',
            data: {
                action: 'formula_deactivation_feedback',
                nonce: formulaDeactivation.nonce,
                reason: reason,
                feedback: feedback
            },
            success: function () {
                proceedWithDeactivation();
            },
            error: function () {
                // Still proceed with deactivation even if AJAX fails.
                proceedWithDeactivation();
            }
        });
    }

    /**
     * Proceed with theme deactivation.
     */
    function proceedWithDeactivation() {
        if (pendingActivationUrl) {
            window.location.href = pendingActivationUrl;
        } else {
            closeModal();
        }
    }

})(jQuery);
