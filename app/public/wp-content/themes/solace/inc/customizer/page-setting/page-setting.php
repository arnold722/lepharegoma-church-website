<?php

function solace_style_page_settings()
{

    // Max Width
    $fullwidth = '100%';
    $boxed = '708px';
    $left = '1280px';
    $right = '1280px';
    $container_custom_layout_width = get_theme_mod( 'solace_container_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
    $single_custom_layout_width = get_theme_mod( 'solace_container_post_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
    $page_custom_layout_width = get_theme_mod( 'solace_container_page_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
    $related_posts = '1280px';

    // Container
    $container_hide_title = get_theme_mod( 'solace_container_hide_title', false );
    $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

    // Blog / Archive
    $archive = get_theme_mod( 'solace_blog_layout_hide_title', false );
    $archive_list_layout = get_theme_mod( 'solace_blog_archive_layout', '1x3' );

    // Single
    $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
    $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );
    $metabox_sidebar_layout = get_post_meta(get_the_ID(), 'sol_layout_singular', 'inherit');
	if (empty($metabox_sidebar_layout)) {
		$metabox_sidebar_layout = 'inherit';
	}

    // Page
    $page_hide_title = get_theme_mod( 'solace_page_layout_hide_title', false );
    $page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' ); 

    // Blog / Archive
    // Is Cart
    $solace_is_cart = false;
    if ( class_exists( 'WooCommerce' ) ) {
        if ( is_cart() ) {
            $solace_is_cart = true;
        }
    }

    // Is Product
    $solace_is_product = false;
    if ( class_exists( 'WooCommerce' ) ) {
        if ( is_product() ) {
            $solace_is_product = true;
        }
    }

    // Is Shop
    $solace_is_shop = false;
    if ( class_exists( 'WooCommerce' ) ) {
        if ( is_shop() ) {
            $solace_is_shop = true;
        }
    }
    
    if (is_archive() || is_search() || is_home() || is_404() || $solace_is_product || $solace_is_shop || $solace_is_cart) {

        $is_elementor_fullwidth = false;

        if ( did_action('elementor/loaded') ) {
            $document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
            if ( $document ) {
                $settings = $document->get_settings();
                if ( ! empty($settings['template']) 
                    && $settings['template'] === 'elementor-full-width' ) {
                    $is_elementor_fullwidth = true;
                }
            }
        }

        if ( $is_elementor_fullwidth ) {
            return;
        }
        if ($container_list_layout === 'fullwidth') {
            $container = "main.main-all {max-width: $fullwidth;}";
            $container .= "body.single-product:not(.solace-sitebuilder-singleproduct) .container.shop-container {max-width: $fullwidth;}";
            $container .= "body.post-type-archive-product .container.shop-container {max-width: $fullwidth;}";
            $container .= "body.woocommerce.archive .container.shop-container {max-width: $fullwidth;}";
            $container .= ".container-404 {max-width: $fullwidth;}";

            // Remove Sidebar Shop
            remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
            wp_add_inline_style('solace-theme', $container);
        } else if ($container_list_layout === 'boxed') {
            $container = "main.main-all {max-width: $boxed; margin: 0 auto;}";
            $container .= "body.single-product:not(.solace-sitebuilder-singleproduct) .container.shop-container {max-width: $boxed; margin: 0 auto;}";
            $container .= "body.post-type-archive-product .container.shop-container {max-width: $boxed; margin: 0 auto;}";
            $container .= "body.woocommerce.archive .container.shop-container {max-width: $boxed; margin: 0 auto;}";
            $container .= ".container-404 {max-width: $boxed; margin: 0 auto;}";

            // Remove Sidebar Shop
            remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
            wp_add_inline_style('solace-theme', $container);
        } else if ($container_list_layout === 'left') {
            $container = "main.main-all {max-width: $left; margin: 0 auto;}";
            $container .= "main.main-all .container-all .row1 {flex-direction: row-reverse; gap: 20px;}";
            $container .= "main.main-all .container-all .row1 aside {width: 30%;}";
            $container .= "body.single-product:not(.solace-sitebuilder-singleproduct) .container.shop-container {max-width: $left; margin: 0 auto;}";
            $container .= "body.woocommerce.archive .container.shop-container {max-width: $left; margin: 0 auto;}";
            $container .= "body.post-type-archive-product .container.shop-container {max-width: $left; margin: 0 auto;}";
            $container .= ".container-404 {max-width: $left; margin: 0 auto;}";

            // Shop WC
            $container .= "body.post-type-archive-product .container.shop-container {max-width: $left; margin: 0 auto;}";
            $container .= "body.post-type-archive-product .container.shop-container .row {flex-wrap: nowrap; flex-direction: row-reverse;}";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-shop {width: 100%; flex-basis: 100%;}";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-sidebar-wrap {width: 30%; max-width: unset;}";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-sidebar-wrap aside {max-width: unset;}";
            $container .= "@media (max-width: 960px) {";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-sidebar-wrap {width: 0;}";
            $container .= "}";            
            wp_add_inline_style('solace-theme', $container);
        } else if ($container_list_layout === 'right') {
            $container = "main.main-all {max-width: $right; margin: 0 auto;}";
            $container .= "main.main-all .container-all .row1 {gap: 20px;}";
            $container .= "main.main-all .container-all .row1 aside {width: 30%;}";       
            $container .= "body.single-product:not(.solace-sitebuilder-singleproduct) .container.shop-container {max-width: $right; margin: 0 auto;}";
            $container .= "body.woocommerce.archive .container.shop-container {max-width: $right; margin: 0 auto;}";
            $container .= ".container-404 {max-width: $right; margin: 0 auto;}";

            // Shop WC
            $container .= "body.post-type-archive-product .container.shop-container {max-width: $right; margin: 0 auto;}";
            $container .= "body.post-type-archive-product .container.shop-container .row {flex-wrap: nowrap;}";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-shop {width: 100%; flex-basis: 100%;}";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-sidebar-wrap {width: 30%; max-width: unset;}";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-sidebar-wrap aside {max-width: unset;}";
            $container .= "@media (max-width: 960px) {";
            $container .= "body.post-type-archive-product .container.shop-container .row .nv-sidebar-wrap {width: 0;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($container_list_layout === 'custom') {
            $arrayDataCustom = json_decode($container_custom_layout_width, true);
            $container = "main.main-all {width: 100%; max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
            $container .= "body.single-product:not(.solace-sitebuilder-singleproduct) .container.shop-container {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";

            $container .= "body.single-product.solace-sitebuilder-singleproduct .container.shop-container {
                max-width: 100% !important;
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }";
            $container .= ".container-404 {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";

            // Remove Sidebar Shop
            remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );            

            // Tablet
            $container .= "@media (max-width: 992px) {";
            $container .= "main.main-all {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "body.single-product .container.shop-container {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "body.post-type-archive-product .container.shop-container {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "}";
            // Mobile
            $container .= "@media (max-width: 748px) {";
            $container .= "main.main-all {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "body.single-product .container.shop-container {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "body.post-type-archive-product .container.shop-container {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        }
    }

    function single1_layout($type) {
        // Max Width
        $fullwidth = '100%';
        $boxed = '708px';
        $left = '1280px';
        $right = '1280px';
        $container_custom_layout_width = get_theme_mod( 'solace_container_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $single_custom_layout_width = get_theme_mod( 'solace_container_post_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $page_custom_layout_width = get_theme_mod( 'solace_container_page_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $related_posts = '1280px';

        // Container
        $container_hide_title = get_theme_mod( 'solace_container_hide_title', false );
        $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

        // Blog / Archive
        $archive = get_theme_mod( 'solace_blog_layout_hide_title', false );
        $archive_list_layout = get_theme_mod( 'solace_blog_archive_layout', '1x3' );

        // Single
        $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
        $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );

        // Page
        $page_hide_title = get_theme_mod( 'solace_page_layout_hide_title', false );
        $page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' ); 

        if ($type === 'fullwidth') {
            $container = "main.main-single1 .container-single .row1 article .boxes-content {max-width: $fullwidth;}";
            $container .= "main.main-single1 .container-single .row1 .related-posts {max-width: $related_posts; margin: 0 auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'boxed') {
            $container = "main.main-single1 .container-single .row1 article .boxes-content {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single1 .container-single .row1 .related-posts {max-width: $related_posts; margin: 0 auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'left') {
            $container = "@media (min-width: 1124px) {";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content {max-width: $left; margin: 0 auto;}";
            $container .= "main.main-single1 .container-single .row1 .related-posts {max-width: $related_posts; margin: 0 auto;}";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active {display: flex; flex-wrap: nowrap; flex-direction: row-reverse; justify-content: space-between; gap: 20px; }";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: 100%;}";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'right') {
            $container = "@media (min-width: 1124px) {";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content {max-width: $right; margin: 0 auto;}";
            $container .= "main.main-single1 .container-single .row1 .related-posts {max-width: $related_posts; margin: 0 auto;}";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active {display: flex; flex-wrap: nowrap; justify-content: space-between; gap: 20px; }";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: 100%;}";
            $container .= "main.main-single1 .container-single .row1 article .boxes-content.sidebar-active aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'custom') {
            if ($single_list_layout === 'inherit' && $single_templates === 'layout 1') {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            } else if ($single_list_layout !== 'inherit' && $single_templates === 'layout 1') {
                $arrayDataCustom = json_decode($single_custom_layout_width, true);
            } else {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            }  
            $container = "main.main-single1 .container-single .row1 article div.boxes-content {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
            $container .= "main.main-single1 .container-single .row1 .related-posts {max-width: $related_posts; margin: 0 auto;}";
            // Tablet
            $container .= "@media (max-width: 992px) {";
            $container .= "main.main-single1 .container-single .row1 article div.boxes-content {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "}";
            // Mobile
            $container .= "@media (max-width: 748px) {";
            $container .= "main.main-single1 .container-single .row1 article div.boxes-content {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        }
    }

    function single2_layout($type) {
        // Max Width
        $fullwidth = '100%';
        $boxed = '708px';
        $left = '1280px';
        $right = '1280px';
        $container_custom_layout_width = get_theme_mod( 'solace_container_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $single_custom_layout_width = get_theme_mod( 'solace_container_post_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $page_custom_layout_width = get_theme_mod( 'solace_container_page_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $related_posts = '1280px';

        // Container
        $container_hide_title = get_theme_mod( 'solace_container_hide_title', false );
        $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

        // Blog / Archive
        $archive = get_theme_mod( 'solace_blog_layout_hide_title', false );
        $archive_list_layout = get_theme_mod( 'solace_blog_archive_layout', '1x3' );

        // Single
        $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
        $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );

        // Page
        $page_hide_title = get_theme_mod( 'solace_page_layout_hide_title', false );
        $page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' ); 

        $subtraction = '20%';

        if ($type === 'fullwidth') {
            $container = "main.main-single2 .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-header .box-info {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single2 .container-single .row1 .related-posts {max-width: 100%; margin-left: auto; margin-right: auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'boxed') {
            $container = "main.main-single2 .container-single .row1 article .boxes-header{max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single2 .container-single .row1 article .box-info{max-width: $boxed; margin: 0 auto; margin-top: 35px;}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single2 .container-single .row1 .related-posts {max-width: $boxed; margin: 0 auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'left') {
            $container = "main.main-single2 .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "@media (min-width: 1124px) {";
            $container .= "main.main-single2 .container-single .row1 article .box-info {max-width: calc($left - $subtraction ); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single2 .container-single .row1 .related-posts {max-width: calc($left - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content.sidebar-active .box-the-content {display: flex; flex-wrap: nowrap; flex-direction: row-reverse; justify-content: space-between; gap: 2.5%;}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content .box-the-content aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'right') {
            $container = "main.main-single2 .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "@media (min-width: 1124px) {";
            $container .= "main.main-single2 .container-single .row1 article .box-info {max-width: calc($right - $subtraction ); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single2 .container-single .row1 .related-posts {max-width: calc($right - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content.sidebar-active .box-the-content {display: flex; flex-wrap: nowrap; justify-content: space-between; gap: 2.5%;}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single2 .container-single .row1 article .boxes-content .box-the-content aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'custom') {
            if ($single_list_layout === 'inherit' && $single_templates === 'layout 2') {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            } else if ($single_list_layout !== 'inherit' && $single_templates === 'layout 2') {
                $arrayDataCustom = json_decode($single_custom_layout_width, true);
            } else {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            }            

            if ($arrayDataCustom['desktop'] >= 1280) {
                $container = "main.main-single2 .container-single .row1 article header.boxes-header .box-thumbnail img {width: 100%;}";
                $container .= "main.main-single2 .container-single .row1 article div.box-info,";
                $container .= "main.main-single2 .container-single .row1 article div.boxes-content,";
                $container .= "main.main-single2 .container-single .row1 div.related-posts {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto;}";
            } else {
                $container = "main.main-single2 .container-single .row1 article header.boxes-header,";
                $container .= "main.main-single2 .container-single .row1 article div.box-info,";
                $container .= "main.main-single2 .container-single .row1 article div.boxes-content,";
                $container .= "main.main-single2 .container-single .row1 div.related-posts {max-width: {$arrayDataCustom['desktop']}px; margin-left: auto; margin-right: auto;}";
            }

            // Tablet
            $container .= "@media (max-width: 992px) {";
            $container .= "main.main-single2 .container-single .row1 article header.boxes-header,";
            $container .= "main.main-single2 .container-single .row1 article div.box-info,";
            $container .= "main.main-single2 .container-single .row1 article div.boxes-content,";
            $container .= "main.main-single2 .container-single .row1 div.related-posts {max-width: {$arrayDataCustom['tablet']}px; margin-left: auto; margin-right: auto;}";
            $container .= "}";

            // Mobile
            $container .= "@media (max-width: 748px) {";
            $container .= "main.main-single2 .container-single .row1 article header.boxes-header,";
            $container .= "main.main-single2 .container-single .row1 article div.box-info,";
            $container .= "main.main-single2 .container-single .row1 article div.boxes-content,";
            $container .= "main.main-single2 .container-single .row1 div.related-posts {max-width: {$arrayDataCustom['mobile']}px; margin-left: auto; margin-right: auto;}";            
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        }
    }    

    function single3_layout($type) {
        // Max Width
        $fullwidth = '100%';
        $boxed = '708px';
        $left = '1280px';
        $right = '1280px';
        $container_custom_layout_width = get_theme_mod( 'solace_container_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $single_custom_layout_width = get_theme_mod( 'solace_container_post_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $page_custom_layout_width = get_theme_mod( 'solace_container_page_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $related_posts = '1280px';

        // Container
        $container_hide_title = get_theme_mod( 'solace_container_hide_title', false );
        $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

        // Blog / Archive
        $archive = get_theme_mod( 'solace_blog_layout_hide_title', false );
        $archive_list_layout = get_theme_mod( 'solace_blog_archive_layout', '1x3' );

        // Single
        $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
        $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );

        // Page
        $page_hide_title = get_theme_mod( 'solace_page_layout_hide_title', false );
        $page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' ); 

        $subtraction = '20%';

        if ($type === 'fullwidth') {
            $container = "main.main-single3 .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-header .box-info {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single3 .container-single .row1 .related-posts {max-width: 100%; margin-left: auto; margin-right: auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'boxed') {
            $container = "main.main-single3 .container-single .row1 article .boxes-header{max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single3 .container-single .row1 article .box-info{max-width: $boxed; margin: 0 auto; margin-top: 35px;}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single3 .container-single .row1 .related-posts {max-width: $boxed; margin: 0 auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'left') {
            $container = "main.main-single3 .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "@media (min-width: 1124px) {";
            $container .= "main.main-single3 .container-single .row1 article .box-info {max-width: calc($left - $subtraction ); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single3 .container-single .row1 .related-posts {max-width: calc($left - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content.sidebar-active .box-the-content {display: flex; flex-wrap: nowrap; flex-direction: row-reverse; justify-content: space-between; gap: 2.5%;}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content .box-the-content aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'right') {
            $container = "main.main-single3 .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "@media (min-width: 1124px) {";
            $container .= "main.main-single3 .container-single .row1 article .box-info {max-width: calc($right - $subtraction ); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single3 .container-single .row1 .related-posts {max-width: calc($right - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content.sidebar-active .box-the-content {display: flex; flex-wrap: nowrap; justify-content: space-between; gap: 2.5%;}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single3 .container-single .row1 article .boxes-content .box-the-content aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'custom') {
            if ($single_list_layout === 'inherit' && $single_templates === 'layout 3') {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            } else if ($single_list_layout !== 'inherit' && $single_templates === 'layout 3') {
                $arrayDataCustom = json_decode($single_custom_layout_width, true);
            } else {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            }            

            if ($arrayDataCustom['desktop'] >= 1280) {
                $container = "main.main-single3 .container-single .row1 article header.boxes-header .box-thumbnail img {width: 100%;}";
                $container .= "main.main-single3 .container-single .row1 article div.box-info,";
                $container .= "main.main-single3 .container-single .row1 article div.boxes-content,";
                $container .= "main.main-single3 .container-single .row1 div.related-posts {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto;}";
            } else {
                $container = "main.main-single3 .container-single .row1 article header.boxes-header,";
                $container .= "main.main-single3 .container-single .row1 article div.box-info,";
                $container .= "main.main-single3 .container-single .row1 article div.boxes-content,";
                $container .= "main.main-single3 .container-single .row1 div.related-posts {max-width: {$arrayDataCustom['desktop']}px; margin-left: auto; margin-right: auto;}";
            }

            // Tablet
            $container .= "@media (max-width: 992px) {";
            $container .= "main.main-single3 .container-single .row1 article header.boxes-header,";
            $container .= "main.main-single3 .container-single .row1 article div.box-info,";
            $container .= "main.main-single3 .container-single .row1 article div.boxes-content,";
            $container .= "main.main-single3 .container-single .row1 div.related-posts {max-width: {$arrayDataCustom['tablet']}px; margin-left: auto; margin-right: auto;}";
            $container .= "}";

            // Mobile
            $container .= "@media (max-width: 748px) {";
            $container .= "main.main-single3 .container-single .row1 article header.boxes-header,";
            $container .= "main.main-single3 .container-single .row1 article div.box-info,";
            $container .= "main.main-single3 .container-single .row1 article div.boxes-content,";
            $container .= "main.main-single3 .container-single .row1 div.related-posts {max-width: {$arrayDataCustom['mobile']}px; margin-left: auto; margin-right: auto;}";            
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        }
    }        

    function single_custom_layout($type) {
        // Max Width
        $fullwidth = '100%';
        $boxed = '708px';
        $left = '1280px';
        $right = '1280px';
        $container_custom_layout_width = get_theme_mod( 'solace_container_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $single_custom_layout_width = get_theme_mod( 'solace_container_post_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $page_custom_layout_width = get_theme_mod( 'solace_container_page_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $related_posts = '1280px';

        // Container
        $container_hide_title = get_theme_mod( 'solace_container_hide_title', false );
        $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

        // Blog / Archive
        $archive = get_theme_mod( 'solace_blog_layout_hide_title', false );
        $archive_list_layout = get_theme_mod( 'solace_blog_archive_layout', '1x3' );

        // Single
        $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
        $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );

        // Page
        $page_hide_title = get_theme_mod( 'solace_page_layout_hide_title', false );
        $page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' ); 

        $subtraction = '20%';

        if ($type === 'fullwidth') {
            $container = "main.main-single-custom .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-header .box-info {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-tag {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .divider-border {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 .related-posts {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-info-author {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 .comments-area {max-width: 100%; margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-posts-navigation {max-width: 100%; margin-left: auto; margin-right: auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'boxed') {
            $container = "main.main-single-custom .container-single .row1 article .boxes-header{max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .box-title {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .box-meta {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-tag {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .divider-border {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .related-posts {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-info-author {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .comments-area {max-width: $boxed; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-posts-navigation {max-width: $boxed; margin: 0 auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'left') {
            $container = "main.main-single-custom .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "@media (min-width: 1124px) {";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-header .box-info {max-width: calc($left - $subtraction - 13px); margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .box-title {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .box-meta {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-tag {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .divider-border {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: calc($left - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 .related-posts {max-width: calc($left - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-info-author {max-width: calc($left - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .comments-area {max-width: calc($left - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-posts-navigation {max-width: calc($left - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content.sidebar-active .box-the-content {display: flex; flex-wrap: nowrap; flex-direction: row-reverse; justify-content: space-between; gap: 2.5%;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content .box-the-content aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'right') {
            $container = "main.main-single-custom .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
            $container .= "@media (min-width: 1124px) {";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-header .box-info {max-width: calc($right - $subtraction - 13px); margin-left: auto; margin-right: auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .box-title {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .box-meta {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-tag {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .divider-border {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: calc($right - $subtraction); margin-left: auto; margin-right: auto; }";
            $container .= "main.main-single-custom .container-single .row1 .related-posts {max-width: calc($right - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-info-author {max-width: calc($right - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .comments-area {max-width: calc($right - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 .box-posts-navigation {max-width: calc($right - $subtraction);  margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content.sidebar-active .box-the-content {display: flex; flex-wrap: nowrap; justify-content: space-between; gap: 2.5%;}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            $container .= "}";
            $container .= "@media (max-width: 1124px) {";
            $container .= "main.main-single-custom .container-single .row1 article .boxes-content .box-the-content aside {width: 100%;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'custom') {
            if ($single_list_layout === 'inherit' && $single_templates === 'custom') {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            } else if ($single_list_layout !== 'inherit' && $single_templates === 'custom') {
                $arrayDataCustom = json_decode($single_custom_layout_width, true);
            } else {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            }            

            if ($arrayDataCustom['desktop'] >= 1280) {
                $container = "main.main-single-custom .container-single .row1 article .boxes-header .box-thumbnail img {width: 100%;}";
                $container .= "main.main-single-custom .container-single .row1 article .boxes-header .box-info {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction - 13px); margin-left: auto; margin-right: auto;}";
                $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto; }";
                $container .= "main.main-single-custom .container-single .row1 article .box-title {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto; }";
                $container .= "main.main-single-custom .container-single .row1 article .box-meta {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto; }";
                $container .= "main.main-single-custom .container-single .row1 article .boxes-content {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto; }";
                $container .= "main.main-single-custom .container-single .row1 article .boxes-tag {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto; }";
                $container .= "main.main-single-custom .container-single .row1 article .divider-border {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto; }";
                $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); margin-left: auto; margin-right: auto; }";
                $container .= "main.main-single-custom .container-single .row1 .related-posts {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); padding: 0; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 .box-info-author {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); padding: 0; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 .comments-area {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); padding: 0; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 .box-posts-navigation {max-width: calc({$arrayDataCustom['desktop']}px - $subtraction); padding: 0; margin: 0 auto;}";
            } else {
                $container = "main.main-single-custom .container-single .row1 article .boxes-header {max-width:{$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 article .boxes-content {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 article .boxes-tag {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 article .divider-border {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 article .box-title {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";               
                $container .= "main.main-single-custom .container-single .row1 article .box-meta {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";               
                $container .= "main.main-single-custom .container-single .row1 .related-posts {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 .box-info-author {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 .comments-area {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
                $container .= "main.main-single-custom .container-single .row1 .box-posts-navigation {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
            }

            // Tablet
            $container .= "@media (max-width: 992px) {";
            $container .= "main.main-single-custom .container-single .row1 article header.boxes-header {max-width:{$arrayDataCustom['tablet']}px; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .box-title {max-width: {$arrayDataCustom['tablet']}px;}";            
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: {$arrayDataCustom['tablet']}px;}";            
            $container .= "main.main-single-custom .container-single .row1 article div.box-meta {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.boxes-content {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.boxes-tag {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.divider-border {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.the-categories {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "main.main-single-custom .container-single .row1 div.related-posts {max-width: {$arrayDataCustom['tablet']}px; margin: 0 auto;}";
            $container .= "main.main-single-custom section.container-single .row1 div.box-info-author {max-width: {$arrayDataCustom['tablet']}px; margin: 0 auto;}";
            $container .= "main.main-single-custom section.container-single .row1 div.comments-area {max-width: {$arrayDataCustom['tablet']}px; margin: 0 auto;}";
            $container .= "main.main-single-custom section.container-single .row1 div.box-posts-navigation  {max-width: {$arrayDataCustom['tablet']}px; margin: 0 auto;}";
            $container .= "main.main-single-custom section.container-single .row1 div.related-posts {max-width: {$arrayDataCustom['tablet']}px; margin: 0 auto;}";            
            $container .= "}";
            // Mobile
            $container .= "@media (max-width: 748px) {";
            $container .= "main.main-single-custom .container-single .row1 article header.boxes-header {max-width:{$arrayDataCustom['mobile']}px; margin: 0 auto;}";
            $container .= "main.main-single-custom .container-single .row1 article .box-title {max-width: {$arrayDataCustom['mobile']}px;}";             
            $container .= "main.main-single-custom .container-single .row1 article .the-categories {max-width: {$arrayDataCustom['mobile']}px;}";             
            $container .= "main.main-single-custom .container-single .row1 article div.box-meta {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.boxes-content {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.boxes-tag {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.divider-border {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "main.main-single-custom .container-single .row1 article div.the-categories {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "main.main-single-custom section.container-single .row1 div.related-posts {max-width: {$arrayDataCustom['mobile']}px; margin: 0 auto;}";            
            $container .= "main.main-single-custom section.container-single .row1 div.box-info-author {max-width: {$arrayDataCustom['mobile']}px; margin: 0 auto;}";            
            $container .= "main.main-single-custom section.container-single .row1 div.comments-area {max-width: {$arrayDataCustom['mobile']}px; margin: 0 auto;}";            
            $container .= "main.main-single-custom section.container-single .row1 div.box-posts-navigation {max-width: {$arrayDataCustom['mobile']}px; margin: 0 auto;}";            
            $container .= "main.main-single-custom section.container-single .row1 div.related-posts {max-width: {$arrayDataCustom['mobile']}px; margin: 0 auto;}";                
            $container .= "}";            
            wp_add_inline_style('solace-theme', $container);
        }
    }     

    function page1_layout($type) {
        // Max Width
        $fullwidth = '100%';
        $boxed = '708px';
        $left = '1280px';
        $right = '1280px';
        $container_custom_layout_width = get_theme_mod( 'solace_container_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $single_custom_layout_width = get_theme_mod( 'solace_container_post_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $page_custom_layout_width = get_theme_mod( 'solace_container_page_width', '{ "mobile": 748, "tablet": 992, "desktop": 1280 }' );
        $related_posts = '1280px';

        // Container
        $container_hide_title = get_theme_mod( 'solace_container_hide_title', false );
        $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

        // Blog / Archive
        $archive = get_theme_mod( 'solace_blog_layout_hide_title', false );
        $archive_list_layout = get_theme_mod( 'solace_blog_archive_layout', '1x3' );

        // Single
        $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
        $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );

        // Page
        $page_hide_title = get_theme_mod( 'solace_page_layout_hide_title', false );
        $page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' ); 

        if ($type === 'fullwidth') {
            $container = "main.main-page1 .container-page .row1 .boxes-header .cover .text {max-width: $fullwidth;}";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content {max-width: $fullwidth;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'boxed') {
            $container = "main.main-page1 .container-page .row1 article .boxes-content {max-width: $boxed; margin: 0 auto;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'left') {
            $container = "main.main-page1 .container-page .row1 article .boxes-content {max-width: $left; margin: 0 auto;}";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content.sidebar-active {display: flex; flex-wrap: nowrap; flex-direction: row-reverse; justify-content: space-between; gap: 20px; }";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'right') {
            $container = "main.main-page1 .container-page .row1 article .boxes-content {max-width: $right; margin: 0 auto;}";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content.sidebar-active {display: flex; flex-wrap: nowrap; justify-content: space-between; gap: 20px; }";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content.sidebar-active .the-content {width: calc(70% - 20px);}";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content.sidebar-active aside {width: 30%;}";
            wp_add_inline_style('solace-theme', $container);
        } else if ($type === 'custom') {
            if ($page_list_layout === 'inherit') {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            } else if ($page_list_layout !== 'inherit') {
                $arrayDataCustom = json_decode($page_custom_layout_width, true);
            } else {
                $arrayDataCustom = json_decode($container_custom_layout_width, true);
            }  

            if ($arrayDataCustom['desktop'] > 1280) {
                $container = "main.main-page1 .container-page .row1 .boxes-header .cover .text {max-width: {$arrayDataCustom['desktop']}px;}";
            } else {
                $container = "main.main-page1 .container-page .row1 .boxes-header .cover .text {max-width: 1280px}";
            }

            $container .= "main.main-page1 .container-page .row1 article .boxes-content {max-width: {$arrayDataCustom['desktop']}px; margin: 0 auto;}";
            // Tablet
            $container .= "@media (max-width: 992px) {";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content {max-width: {$arrayDataCustom['tablet']}px;}";
            $container .= "}";
            // Mobile
            $container .= "@media (max-width: 748px) {";
            $container .= "main.main-page1 .container-page .row1 article .boxes-content {max-width: {$arrayDataCustom['mobile']}px;}";
            $container .= "}";
            wp_add_inline_style('solace-theme', $container);
        }
    } 

    // Single1 Inherit
    if ($single_list_layout === 'inherit' && $single_templates === 'layout 1' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single1_layout($container_list_layout);
        }
    }

    // Single1 Single_templates
    if ($single_list_layout !== 'inherit' && $single_templates === 'layout 1' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single1_layout($single_list_layout);
        }
    }

    // Single1 metabox_templates
    if ($single_templates === 'layout 1' && $metabox_sidebar_layout !== 'inherit') {
        if (is_single()) {
            single1_layout($metabox_sidebar_layout);
        }
    }

    // Single2 Inherit
    if ($single_list_layout === 'inherit' && $single_templates === 'layout 2' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single2_layout($container_list_layout);
        }
    }    

    // Single2 Single_templates
    if ($single_list_layout !== 'inherit' && $single_templates === 'layout 2' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single2_layout($single_list_layout);
        }
    }

    // Single2 metabox_templates
    if ($single_templates === 'layout 2' && $metabox_sidebar_layout !== 'inherit') {
        if (is_single()) {
            single2_layout($metabox_sidebar_layout);
        }
    }    

    // Single3 Inherit
    if ($single_list_layout === 'inherit' && $single_templates === 'layout 3' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single3_layout($container_list_layout);
        }
    }

    // Single3 Single_templates
    if ($single_list_layout !== 'inherit' && $single_templates === 'layout 3' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single3_layout($single_list_layout);
        }
    }

    // Single3 metabox_templates
    if ($single_templates === 'layout 3' && $metabox_sidebar_layout !== 'inherit') {
        if (is_single()) {
            single3_layout($metabox_sidebar_layout);
        }
    }    

    // Single custom Inherit
    if ($single_list_layout === 'inherit' && $single_templates === 'custom' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single_custom_layout($container_list_layout);
        }
    }

    // Single custom Single_templates
    if ($single_list_layout !== 'inherit' && $single_templates === 'custom' && $metabox_sidebar_layout === 'inherit') {
        if (is_single()) {
            single_custom_layout($single_list_layout);
        }
    }

    // Single custom metabox_templates
    if ($single_templates === 'custom' && $metabox_sidebar_layout !== 'inherit') {
        if (is_single()) {
            single_custom_layout($metabox_sidebar_layout);
        }
    }    

    // Page1 Inherit
    if ($page_list_layout === 'inherit' && $metabox_sidebar_layout === 'inherit') {
        if (is_page()) {
            page1_layout($container_list_layout);
        }
    }

    // Page1 Page_templates
    if ($page_list_layout !== 'inherit' && $metabox_sidebar_layout === 'inherit') {
        if (is_page()) {
            page1_layout($page_list_layout);
        }
    }

    // Page1 metabox_templates
    if ($metabox_sidebar_layout !== 'inherit') {
        if (is_page()) {
            page1_layout($metabox_sidebar_layout);
        }
    }    

}
add_action('wp_enqueue_scripts', 'solace_style_page_settings');
