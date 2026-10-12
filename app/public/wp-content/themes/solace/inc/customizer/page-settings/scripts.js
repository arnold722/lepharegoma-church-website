/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */
(function ($) {

    // Columns
    $('#solace_blog_layout_custom_columns').css('pointer-events', 'none');
    $('#solace_blog_layout_custom_columns.count').attr('disabled', 'disabled');

    $('#solace_blog_layout_custom_columns.count').prop('disabled', true);
    $('#customize-control-solace_blog_layout_custom_posts .count').prop('disabled', true);
    $(document).on('click', '#solace_blog_layout_custom_columns .plus', function () {
        const total = $('#solace_blog_layout_custom_columns .count').val();
        const min = $('#solace_blog_layout_custom_columns .count').attr('min');
        const max = $('#solace_blog_layout_custom_columns .count').attr('max');
        if (total != max) {
            $('#solace_blog_layout_custom_columns .count').val(parseInt($('#solace_blog_layout_custom_columns .count').val()) + 1);
            $('#solace_blog_layout_custom_columns .count').trigger('change');
        }
    });

    $(document).on('click', '#customize-control-solace_blog_archive_layout [data-option="3x3"],#customize-control-solace_blog_archive_layout [data-option="2x3"],#customize-control-solace_blog_archive_layout [data-option="1x3"]', function () {
        $('#customize-control-solace_blog_archive_layout label[data-option="custom"],#customize-control-solace_blog_archive_layout label[data-option="custom"] button').removeClass('active');
    });

    // $(document).on('click','#customize-control-solace_blog_archive_layout [data-option="3x3"]',function() {
    //     $('label[data-option="3x3"]').addClass('active');
    //     $('label[data-option="3x3"] button').addClass('active');
    // });
    // $(document).on('click','#customize-control-solace_blog_archive_layout [data-option="2x3"]',function() {
    //     $('label[data-option="2x3"]').addClass('active');
    //     $('label[data-option="2x3"] button').addClass('active');
    // });
    // $(document).on('click','#customize-control-solace_blog_archive_layout [data-option="1x3"]',function() {
    //     $('label[data-option="1x3"]').addClass('active');
    //     $('label[data-option="1x3"] button').addClass('active');
    // });

    $(document).on('click','#customize-control-solace_blog_archive_layout .title-customize',function() {
        wp.customize('solace_blog_archive_layout').set('custom');
        $('#customize-control-solace_blog_archive_layout label[data-option="custom"]').addClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="custom"] button').addClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="3x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="3x3"] button').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="2x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="2x3"] button').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="1x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="1x3"] button').removeClass('active');
    });

    


    $(document).on('click', '#solace_blog_layout_custom_columns .minus', function () {
        // alert('klik custom minus');
        if ($('#solace_blog_layout_custom_columns .count').val() >0){
            wp.customize('solace_blog_archive_layout').set('custom');
            $('#customize-control-solace_blog_archive_layout label[data-option="custom"]').addClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="custom"] button').addClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="3x3"]').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="3x3"] button').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="2x3"]').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="2x3"] button').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="1x3"]').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="1x3"] button').removeClass('active');
            $('#solace_blog_layout_custom_columns .count').val(parseInt($('#solace_blog_layout_custom_columns .count').val()) - 1);
            $('#solace_blog_layout_custom_columns .count').trigger('change');

            if ($('#solace_blog_layout_custom_columns .count').val() == 0) {
                const total = $('#solace_blog_layout_custom_columns .count').val();
                const min = $('#solace_blog_layout_custom_columns .count').attr('min');
                const max = $('#solace_blog_layout_custom_columns .count').attr('max');
                if (min != 0) {
                    $('#solace_blog_layout_custom_columns .count').val(1);
                }
            }
        }
    });

    $(document).on('click', '#solace_blog_layout_custom_columns .plus', function () {
        // alert($('#solace_blog_layout_custom_columns .count').val());
        
        if ($('#solace_blog_layout_custom_columns .count').val() <=5){
            wp.customize('solace_blog_archive_layout').set('custom');
            $('#customize-control-solace_blog_archive_layout label[data-option="custom"]').addClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="custom"] button').addClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="3x3"]').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="3x3"] button').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="2x3"]').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="2x3"] button').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="1x3"]').removeClass('active');
            $('#customize-control-solace_blog_archive_layout label[data-option="1x3"] button').removeClass('active');
            $('#solace_blog_layout_custom_columns .count').val(parseInt($('#solace_blog_layout_custom_columns .count').val()-1) + 1);
            $('#solace_blog_layout_custom_columns .count').trigger('change');

            if ($('#solace_blog_layout_custom_columns .count').val() == 0) {
                const total = $('#solace_blog_layout_custom_columns .count').val();
                const min = $('#solace_blog_layout_custom_columns .count').attr('min');
                const max = $('#solace_blog_layout_custom_columns .count').attr('max');
                if (min != 0) {
                    $('#solace_blog_layout_custom_columns .count').val(1);
                }
            }
        }
    });

    // Posts
    
    // $(document).on('click', '#solace_blog_layout_custom_columns .minus', function () {

    $(document).on('click', '#solace_blog_layout_custom_posts .plus', function () {
        // alert('post plus');
        wp.customize('solace_blog_archive_layout').set('custom');
        $('#customize-control-solace_blog_archive_layout label[data-option="custom"]').addClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="custom"] button').addClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="3x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="3x3"] button').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="2x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="2x3"] button').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="1x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="1x3"] button').removeClass('active');
        
        const total = $('#solace_blog_layout_custom_posts .count').val();
        const min = $('#solace_blog_layout_custom_posts .count').attr('min');
        const max = $('#solace_blog_layout_custom_posts .count').attr('max');
        if (total != max) {
            $('#solace_blog_layout_custom_posts .count').val(parseInt($('#solace_blog_layout_custom_posts .count').val()) + 1);
            $('#solace_blog_layout_custom_posts .count').trigger('change');
        }
    });

    $(document).on('click', '#solace_blog_layout_custom_posts .minus', function () {
        // alert('post minus');
        wp.customize('solace_blog_archive_layout').set('custom');
        $('#customize-control-solace_blog_archive_layout label[data-option="custom"]').addClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="custom"] button').addClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="3x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="3x3"] button').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="2x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="2x3"] button').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="1x3"]').removeClass('active');
        $('#customize-control-solace_blog_archive_layout label[data-option="1x3"] button').removeClass('active');

        $('#solace_blog_layout_custom_posts .count').val(parseInt($('#solace_blog_layout_custom_posts .count').val()) - 1);
        $('#solace_blog_layout_custom_posts .count').trigger('change');

        if ($('#solace_blog_layout_custom_posts .count').val() == 0) {
            const total = $('#solace_blog_layout_custom_posts .count').val();
            const min = $('#solace_blog_layout_custom_posts .count').attr('min');
            const max = $('#solace_blog_layout_custom_posts .count').attr('max');
            if (min != 0) {
                $('#solace_blog_layout_custom_posts .count').val(1);
            }
        }
    });

    wp.customize.bind('ready', function () {

        var hideTitlePageValue = wp.customize('solace_page_layout').get();
        if (hideTitlePageValue === 'inherit') {
            // $('#customize-control-solace_page_layout_hide_title').css('display', 'none');
            $('#customize-control-solace_page_layout_hide_title .components-form-toggle input').prop('disabled', true);
            $('#customize-control-solace_page_layout_hide_title .components-form-toggle').addClass('disabled-checkbox');
        }
        wp.customize('solace_page_layout_hide_title', function (value) {
            value.bind(function (newHideTitlePageValue) {
            if (newHideTitlePageValue === 'inherit') {
                // $('#customize-control-solace_page_layout_hide_title').css('display', 'none');
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle input').prop('disabled', true);
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle').addClass('disabled-checkbox');
            } else {
                // $('#customize-control-solace_page_layout_hide_title').css('display', 'block');
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle input').prop('disabled', false);
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle').removeClass('disabled-checkbox');
            }
            });
        });

        var hideTitlePostValue = wp.customize('solace_post_layout').get();
        if (hideTitlePostValue === 'inherit') {
            // $('#customize-control-solace_post_layout_hide_title').css('display', 'none');
            $('#customize-control-solace_post_layout_hide_title .components-form-toggle input').prop('disabled', true);
            $('#customize-control-solace_post_layout_hide_title .components-form-toggle').addClass('disabled-checkbox');
        }
        wp.customize('solace_post_layout_hide_title', function (value) {
            value.bind(function (newHideTitlePostValue) {
            if (newHideTitlePostValue === 'inherit') {
                // $('#customize-control-solace_post_layout_hide_title').css('display', 'none');
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle input').prop('disabled', true);
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle').addClass('disabled-checkbox');

            } else {
                // $('#customize-control-solace_post_layout_hide_title').css('display', 'block');
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle input').prop('disabled', false);
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle').removeClass('disabled-checkbox');
            }
            });
        });

        wp.customize('solace_blog_archive_layout', function(value) {
            value.bind(function(newVal) {
              if (newVal === 'custom') {
                wp.customize.previewer.send('update-solace-blog-archive-layout', newVal);
                wp.customize.previewer.refresh();
                
              }
            });
          });

        // wp.customize('solace_wc_custom_general_buttons_elementor', function(value) {
        //     // console.log('okeeee');
        //     value.bind(function(newval) {
        //         console.log('Button override toggled to:', newval ? 'ON' : 'OFF');
                
        //         wp.customize.previewer.send('refresh');
        //         wp.customize.previewer.refresh(); 
        //     });
        // });

        wp.customize('solace_wc_custom_general_buttons_elementor', function(value) {
            value.bind(function(newval) {
                console.log('Button override toggled to:', newval ? 'ON' : 'OFF');
                
                wp.customize.instance('solace_wc_custom_general_buttons_elementor').set(newval);
        
                wp.customize.previewer.send('refresh');
                wp.customize.previewer.refresh();
            });
        });
        

        // Only show the color hue control when there's a custom color scheme.
        wp.customize('solace_blog_archive_layout', function (setting) {
            wp.customize.control('solace_blog_layout_custom_columns', function (control) {
                var visibility = function () {
                    if ('custom' === setting.get()) {
                        control.container.slideDown(350);
                    } else {
                        control.container.slideUp(350);
                    }
                };

                visibility();
                setting.bind(visibility);
            });

            wp.customize.control('solace_blog_layout_custom_posts', function (control) {
                var visibility = function () {
                    if ('custom' === setting.get()) {
                        control.container.slideDown(350);
                    } else {
                        control.container.slideUp(350);
                    }
                };

                visibility();
                setting.bind(visibility);
            });
        });
    });
})(jQuery);

( function( $ ) {
    $(document).ready(function() {

        $(document).on('click','#customize-control-solace_page_layout .solace-radio-image .option label', function() {
            if ($('#customize-control-solace_page_layout .solace-radio-image .option:first-child label').hasClass('active')) {
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle input').prop('disabled', true);
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle').addClass('disabled-checkbox');
            } else {
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle input').prop('disabled', false);
                $('#customize-control-solace_page_layout_hide_title .components-form-toggle').removeClass('disabled-checkbox');
            }
        });

        $(document).on('click','#customize-control-solace_post_layout .solace-radio-image .option label', function() {
            if ($('#customize-control-solace_post_layout .solace-radio-image .option:first-child label').hasClass('active')) {
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle input').prop('disabled', true);
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle').addClass('disabled-checkbox');

            } else {
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle input').prop('disabled', false);
                $('#customize-control-solace_post_layout_hide_title .components-form-toggle').removeClass('disabled-checkbox');
            }
       
        });

        var $customColumn = $('#solace_blog_layout_custom_columns');
        var $customPosts = $('#solace_blog_layout_custom_posts');
        var $archiveLayout = $('#customize-control-solace_blog_archive_layout .solace-radio-image .option [data-option="custom"] span');
      
        $customPosts.insertAfter($archiveLayout);
        $customColumn.insertAfter($archiveLayout);

        $('#solace_blog_layout_custom_columns.count').attr('disabled', 'disabled');

        $('#solace_blog_layout_custom_columns.count').prop('disabled', true);

        document.addEventListener('click', function(event) {
            if (event.target.matches('.header-top .row')) {
              const element = document.querySelector('.header-top .row');
              if (element) {

              }
            }
          });
        
    });
	
})( jQuery );

