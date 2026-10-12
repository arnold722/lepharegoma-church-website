<?php 
// Add Meta Box Sidebar Layout
function solace_metabox_add_sidebar_layout() {
    // Page
    add_meta_box(
        'sol_sidebar_layout', 
        'Sidebar Layout', 
        'solace_show_sidebar_layout', 
        'page', 
        'side', 
        'high' 
    );

    // Post
	add_meta_box(
        'sol_sidebar_layout',
        'Sidebar Layout', 
        'solace_show_sidebar_layout', 
        'post', 
        'side', 
        'high' 
    );
}
add_action('add_meta_boxes', 'solace_metabox_add_sidebar_layout');

// Callback Meta Box
function solace_show_sidebar_layout($post) {
    wp_nonce_field( basename(__FILE__), "sidebar_layout_image_nonce");
    $sol_layout_singular = get_post_meta($post->ID, 'sol_layout_singular', 'inherit');
    $sol_layout_singular = !empty( $sol_layout_singular ) ? $sol_layout_singular : 'inherit';

    $choose_sol_layout_singular = array(
        'inherit' => get_template_directory_uri() .'/assets/img/customizer/layout_inherit.svg',
        'boxed' => get_template_directory_uri() .'/assets/img/customizer/layout_boxed.svg',
        'fullwidth' => get_template_directory_uri() .'/assets/img/customizer/layout_wide.svg',
		'left' => get_template_directory_uri() .'/assets/img/customizer/layout_left.svg',
		'right' => get_template_directory_uri() .'/assets/img/customizer/layout_right.svg',
    );

    foreach ($choose_sol_layout_singular as $key => $value) {
        ?>
        <style>
        #sol_sidebar_layout .handle-actions {
            margin-right: 8px;
        }

        #sol_sidebar_layout button {
            display: none;
        }

        #sol_sidebar_layout button.handlediv {
            display: block;
        }

        #sol_sidebar_layout.postbox .toggle-indicator::before {
            content: "\f343";
            font-weight: 500;
            color: #000;
            font-size: 16px;
        }

        #sol_sidebar_layout.postbox.closed .toggle-indicator::before {
            content: "\f347";
            font-weight: 500;
            color: #000;
            font-size: 16px;
        }

        #sol_sidebar_layout.postbox.closed .inside {
            display: none;
        }

        #sol_sidebar_layout h2 {
            padding: 16px !important;
            font-size: 13px;
            font-weight: 500 !important;
        }

        #sol_sidebar_layout .inside {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            background-color: #072251;
            padding: 18px;
        }

        #sol_sidebar_layout .inside label {
            width: calc(50% - 15px);
            margin-bottom: 20px;
        }

        #sol_sidebar_layout .inside label:last-child {
            margin-bottom: 0;
        }

        #sol_sidebar_layout .inside input[type="radio"] {
            display: none;
        }

        #sol_sidebar_layout .inside input[type="radio"][name="sol_layout_singular"]:checked+img {
            outline: 4px solid #FF9500;
            border-radius: 10px;
        }

        #sol_sidebar_layout .inside input[type="radio"][name="sol_layout_singular"]:checked+img::after {
            content: "";
            display: block;
            background-image: url(../img/customizer/ok-sign.svg);
            position: absolute;
            top: -11px;
            right: -11px;
            width: 21px;
            height: 21px;
            z-index: 9;
            background-repeat: no-repeat;
            background-color: #000;
            border-radius: 50px;
        }
        </style>
        <label>
        <input type="radio" name="sol_layout_singular" value="<?php echo esc_attr($key); ?>" <?php checked( $sol_layout_singular, $key ); ?> />
            <img style="width: 100%; height: auto;" src="<?php echo esc_url($value); ?>">
        </label>
        <?php
    }

    // Container
    $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );
    $container_custom_layout_width = get_theme_mod( 'solace_container_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );

    // Single
    $single_custom_layout_width = get_theme_mod( 'solace_container_post_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
    $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
    $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );

    // Single Inherit
    $width_inherit = '';
    if ($single_list_layout === 'inherit' ) {
        if ($container_list_layout === 'boxed') {
            $width_inherit = '708px';
        } else if ($container_list_layout === 'fullwidth') {
            $width_inherit = '100%';
        } else if ($container_list_layout === 'left' || $container_list_layout === 'right') {
            $width_inherit = '1280px';
        }
    }

    // Single Single_templates
    if ($single_list_layout !== 'inherit') {
        if ($single_list_layout === 'boxed') {
            $width_inherit = '708px';
        } else if ($single_list_layout === 'fullwidth') {
            $width_inherit = '100%';
        } else if ($single_list_layout === 'left' || $single_list_layout === 'right') {
            $width_inherit = '1280px';
        }
    } 
    ?>
    <script>
    ( function( $ ) {
        $('#sol_sidebar_layout input').click(function(){
            let getVal = $(this).val();
            if (getVal === 'inherit') {
                $('.editor-styles-wrapper .wp-block').css('max-width', '<?php echo esc_html($width_inherit); ?>');
                // console.log('inherit');
                // console.log('<?php echo esc_html($width_inherit); ?>');
            } else if (getVal === 'boxed') {
                $('.editor-styles-wrapper .wp-block').css('max-width', '708px');
                // console.log('boxed');
            } else if (getVal === 'fullwidth') {
                $('.editor-styles-wrapper .wp-block').css('max-width', '100%');
                // console.log('fullwidth');
            } else if (getVal === 'left' || getVal === 'right') {
                $('.editor-styles-wrapper .wp-block').css('max-width', '1280px');
                // console.log('left right');
            }
        });
    }( jQuery ) );
    </script>
    <?php
}

// Update Post Meta
function solace_save_sidebar_layout($post_id) {

    // Nonce Verify
    if( !isset( $_POST['sidebar_layout_image_nonce']) || !wp_verify_nonce($_POST['sidebar_layout_image_nonce'], basename(__FILE__)) ){
        return $post_id;
    }
	
	// Check User
	if( !current_user_can( 'edit_post', $post_id ) ){
		return;
	}

    // Save Data
    $data_acara = '';
    if (isset($_POST['sol_layout_singular'])) {
        $data_acara = sanitize_key($_POST['sol_layout_singular']);
    } else {
        $data_acara = '';
    }
    update_post_meta($post_id, 'sol_layout_singular', $data_acara);
}
add_action("save_post", "solace_save_sidebar_layout", 10, 2);

