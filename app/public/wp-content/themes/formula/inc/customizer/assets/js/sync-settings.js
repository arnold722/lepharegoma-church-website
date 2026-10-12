(function ($) {
    "use strict";

    $(document).ready(function () {
        
        // Listen for click on the custom button
        $(document).on('click', '#formula-sync-btn', function (e) {
            e.preventDefault();
            
            var button = $(this);
            var originalText = button.text();

            // Disable button and show loading state
            button.addClass('disabled').text(formulaSync.syncing_text);

            $.ajax({
                type: 'POST',
                url: formulaSync.ajax_url,
                data: {
                    action: 'formula_sync_settings',
                    nonce: formulaSync.nonce
                },
                success: function (response) {
                    if (response.success) {
                        button.text(response.data.message);
                        button.addClass('button-primary').removeClass('button-secondary'); // Visual success cue
                        
                        // Re-enable after a delay (optional)
                        setTimeout(function() {
                            button.text(originalText).removeClass('disabled button-primary').addClass('button-secondary');
                        }, 5000);

                    } else {
                        button.text(response.data.message); // Error message
                        setTimeout(function() {
                            button.text(originalText).removeClass('disabled');
                        }, 3000);
                    }
                },
                error: function () {
                    button.text('Error. Try again.');
                    setTimeout(function() {
                        button.text(originalText).removeClass('disabled');
                    }, 3000);
                }
            });
        });
    });

})(jQuery);
