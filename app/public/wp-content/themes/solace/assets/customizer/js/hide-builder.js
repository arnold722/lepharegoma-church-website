(function ($) {
    wp.customize.bind('ready', function () {
        // console.log(JSON.stringify(section, null, 4));
        // Panel Header
        let panelHeader = wp.customize.panel( 'hfg_header' );
        panelHeader.expanded.bind( function( isExpanding ) {
            if(! isExpanding){
                setTimeout(function(){
                    $('body').removeClass('hide-builder-header');
                    $('.hide-builder .text').text('Hide Builder');
                }, 200);
            }
        });        

        // Panel Footer
        let panelFooter = wp.customize.panel( 'hfg_footer' );
        panelFooter.expanded.bind( function( isExpanding ) {
            if(! isExpanding){
                $('.wp-full-overlay').css('background', 'var(--sol-color-page-title-background)');

                setTimeout(function(){
                    $('.wp-full-overlay').attr('style', '');
                    $('body').removeClass('hide-builder-footer');
                    $('.hide-builder .text').text('Hide Builder');
                }, 200);
            }
        });         
    });
})(jQuery);
