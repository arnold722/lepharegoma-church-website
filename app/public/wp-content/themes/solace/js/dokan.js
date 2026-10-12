jQuery(document).ready(function($){
    $('#dokan-content .products a.button.product_type_simple, .dokan-store-name .products a.button.product_type_simple').addClass('dokan-btn-theme');
	$('body.dokan-theme-solace a.button.product_type_simple.add_to_cart_button.ajax_add_to_cart').addClass('alt');
    var buttonStyles = getComputedStyle(document.querySelector('.dokan-btn-theme'));

    var color = buttonStyles.color;
    var backgroundColor = buttonStyles.backgroundColor; 
    var borderColor = buttonStyles.borderColor; 

    function rgbToHex(rgb) {
        const rgbArray = rgb.match(/\d+/g); 
        const hex = rgbArray.map(value => {
            const hexValue = parseInt(value).toString(16).padStart(2, '0'); 
            return hexValue;
        }).join('');
        return `#${hex.toUpperCase()}`; 
    }

    var hexColor = rgbToHex(color);
    var hexBackgroundColor = rgbToHex(backgroundColor);
    var hexBorderColor = rgbToHex(borderColor);

    $('.button.product_type_simple.dokan-btn-theme').each(function() {
        $(this).css({
            'color': hexColor, 
            'background-color': hexBackgroundColor, 
            'border-color': hexBorderColor 
        });

        console.log('Applied Color:', hexColor);
        console.log('Applied Background Color:', hexBackgroundColor);
        console.log('Applied Border Color:', hexBorderColor);
    });

    $(this).hover(
        function() {
            $(this).css({
                'color': hexColor, 
                'background-color': hexBorderColor,
                'border-color': hexBackgroundColor 
            });
        },
        function() {
            // Revert to the original style.
            $(this).css({
                'color': hexColor,
                'background-color': hexBackgroundColor,
                'border-color': hexBorderColor
            });
        }
    );
});