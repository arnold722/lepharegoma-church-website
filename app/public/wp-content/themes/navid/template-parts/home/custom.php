<?php
/**
 * Homepage Section: Custom Banner / CTA
 *
 * @package Navid
 */

$layout   = get_theme_mod( 'navid_custom_banner_layout', 'split_left' );

// Enforce Freemium Split: Fallback to Split Screen if Pro is not active
if ( ! function_exists( 'navid_pro_is_active' ) || ! navid_pro_is_active() ) {
    if ( in_array( $layout, array( 'grid_3', 'overlay' ) ) ) {
        $layout = 'split_left';
    }
}

$overlay  = get_theme_mod( 'navid_custom_banner_overlay', 60 );
$overlay_opacity = absint( $overlay ) / 100;
$bg_color = get_theme_mod( 'navid_custom_banner_bg_color', '' );

// Fetch Global Image Radius
$image_radius = intval( get_theme_mod( 'navid_global_image_radius', 0 ) );

// Fetch Global Typography Scale
$heading_scale = get_theme_mod( 'navid_heading_scale', 100 );
$scale_factor  = $heading_scale / 100;
$h2_calc       = 'calc(clamp(22px, 3.5vw, 36px) * ' . esc_attr( $scale_factor ) . ')';
$h3_calc       = 'calc(clamp(18px, 2.5vw, 28px) * ' . esc_attr( $scale_factor ) . ')';
$section_calc  = 'calc(clamp(24px, 2.5vw, 32px) * ' . esc_attr( $scale_factor ) . ')';

// Fetch Global Section Heading
$section_heading = get_theme_mod( 'navid_custom_banner_section_title', '' );

// Section style (Only applied to grid and overlay now, background removed from global section wrapper)
$section_style = 'overflow: hidden;';

// Col 1 Data
$image    = get_theme_mod( 'navid_custom_banner_image', '' );
$title    = get_theme_mod( 'navid_custom_banner_title', 'Important Disclosure' );
$text     = get_theme_mod( 'navid_custom_banner_text', '' );
$btn_text = get_theme_mod( 'navid_custom_banner_btn_text', '' );
$btn_url  = get_theme_mod( 'navid_custom_banner_btn_url', '' );
$btn_target = get_theme_mod( 'navid_custom_banner_btn_target', '_blank' );

// If no content is added, don't output anything.
if ( empty( $title ) && empty( $text ) && empty( $image ) ) {
    return;
}
?>


<section class="navid-section navid-custom-cta layout-<?php echo esc_attr( $layout ); ?>" style="<?php echo esc_attr( $section_style ); ?>">

    <?php if ( 'grid_3' === $layout ) : ?>
        <!-- 3-COLUMN GRID LAYOUT -->
        <div class="container">
            <?php if ( ! empty( $section_heading ) ) : ?>
                <div class="section-bar anim-up" style="margin-bottom: 40px;">
                    <h2 style="font-size: <?php echo $section_calc; ?>;"><?php echo esc_html( $section_heading ); ?></h2>
                </div>
            <?php endif; ?>
            
            <div class="cta-grid-wrapper" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
                <?php
                for ( $i = 1; $i <= 3; $i++ ) {
                    $suffix = ( $i === 1 ) ? '' : "_{$i}";
                    $col_img   = get_theme_mod( 'navid_custom_banner_image' . $suffix, '' );
                    $col_title = get_theme_mod( 'navid_custom_banner_title' . $suffix, "Column {$i}" );
                    $col_text  = get_theme_mod( 'navid_custom_banner_text' . $suffix, '' );
                    $col_url   = get_theme_mod( 'navid_custom_banner_btn_url' . $suffix, '' );
                    $col_target = get_theme_mod( 'navid_custom_banner_btn_target' . $suffix, '_blank' );
                    $col_btn_text = get_theme_mod( 'navid_custom_banner_btn_text' . $suffix, 'Explore' );
                    
                    if ( empty( $col_img ) && empty( $col_title ) ) continue;
                    
                    $col_tag = ! empty( $col_url ) ? 'a' : 'div';
                    $col_href = ! empty( $col_url ) ? ' href="' . esc_url( $col_url ) . '" target="' . esc_attr( $col_target ) . '"' : '';
                    ?>
                    <<?php echo $col_tag . $col_href; ?> class="cta-grid-card" style="border-radius: 0;">
                        <?php if ( ! empty( $col_img ) ) : ?>
                            <div class="cta-grid-bg">
                                <img src="<?php echo esc_url( $col_img ); ?>" alt="" style="border-radius: 0;" />
                                <div class="cta-grid-overlay" style="border-radius: 0;"></div>
                                <div class="cta-grid-overlay-hover" style="border-radius: 0;"></div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="cta-grid-content">
                            <h3 class="cta-grid-title" style="font-size: <?php echo $h3_calc; ?>;"><?php echo wp_kses_post( $col_title ); ?></h3>
                            
                            <?php if ( ! empty( $col_text ) || ! empty( $col_url ) ) : ?>
                                <div class="cta-grid-desc">
                                    <div class="cta-grid-desc-inner">
                                        <?php if ( ! empty( $col_text ) ) : ?>
                                            <p style="color: rgba(255,255,255,0.85); font-size: 0.92em; line-height: 1.6; margin-bottom: 0; margin-top: 15px;"><?php echo wp_kses_post( $col_text ); ?></p>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $col_url ) ) : ?>
                                            <span class="cta-explore-link cta-explore-link-white" style="margin-top: 15px; display: inline-block;"><?php echo esc_html( $col_btn_text ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </<?php echo $col_tag; ?>>
                <?php } ?>
            </div>
        </div>

    <?php elseif ( 'overlay' === $layout ) : ?>
        <!-- FULL WIDTH OVERLAY LAYOUT -->
        <div class="container">
            <?php if ( ! empty( $section_heading ) ) : ?>
                <div class="section-bar anim-up" style="margin-bottom: 40px;">
                    <h2 style="font-size: <?php echo $section_calc; ?>;"><?php echo esc_html( $section_heading ); ?></h2>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="cta-overlay-wrapper" style="position: relative; padding: 120px 0; color: #ffffff; <?php echo ! empty( $bg_color ) ? 'background-color: ' . esc_attr( $bg_color ) . ';' : ''; ?>">
            <?php if ( ! empty( $image ) ) : ?>
                <div class="cta-bg" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                    <img src="<?php echo esc_url( $image ); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover; display: block;" />
                    <div class="cta-overlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,<?php echo esc_attr( $overlay_opacity ); ?>);"></div>
                </div>
            <?php endif; ?>
            <div class="container" style="position: relative; z-index: 2; text-align: center;">
                <div style="max-width: 800px; margin: 0 auto;">
                    <?php if ( ! empty( $title ) ) : ?>
                        <h2 class="navid-section-title" style="color: #ffffff; margin-bottom: 24px; line-height: 1.1; letter-spacing: -0.02em; font-size: <?php echo $h2_calc; ?>;"><?php echo wp_kses_post( $title ); ?></h2>
                    <?php endif; ?>
                    <?php if ( ! empty( $text ) ) : ?>
                        <div class="cta-content" style="font-size: 0.92em; line-height: 1.6; margin-bottom: 40px; opacity: 0.9;">
                            <?php echo wpautop( wp_kses_post( $text ) ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $btn_text ) && ! empty( $btn_url ) ) : ?>
                        <a href="<?php echo esc_url( $btn_url ); ?>" class="cta-explore-link cta-explore-link-white" target="<?php echo esc_attr( $btn_target ); ?>">
                            <?php echo esc_html( $btn_text ); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php else : ?>
        <!-- SPLIT SCREEN LAYOUT (Fused Card) -->
        <div class="container">
            <?php if ( ! empty( $section_heading ) ) : ?>
                <div class="section-bar anim-up" style="margin-bottom: 40px;">
                    <h2 style="font-size: <?php echo $section_calc; ?>;"><?php echo esc_html( $section_heading ); ?></h2>
                </div>
            <?php endif; ?>
            
            <?php 
            $img_order = ( 'split_left' === $layout ) ? 1 : 2;
            $txt_order = ( 'split_left' === $layout ) ? 2 : 1;
            
            // Background color for the text side if section bg is transparent, fallback to cream
            $card_bg = ! empty( $bg_color ) ? $bg_color : 'var(--cream)';
            
            // If they pick a custom color, they might need white text. But default cream uses dark text naturally.
            $text_color = ! empty( $bg_color ) ? '#ffffff' : 'var(--charcoal)';
            
            // Determine if we need the light or dark link animation based on text color
            $link_class = ! empty( $bg_color ) ? 'cta-explore-link-white' : 'cta-explore-link-dark';
            ?>
            <div class="cta-split-card" style="border-radius: <?php echo esc_attr( $image_radius ); ?>px; background-color: <?php echo esc_attr( $card_bg ); ?>; color: <?php echo esc_attr( $text_color ); ?>;">

                <!-- Image Side -->
                <div class="cta-split-image" style="order: <?php echo esc_attr( $img_order ); ?>;">
                    <?php if ( ! empty( $image ) ) : ?>
                        <img src="<?php echo esc_url( $image ); ?>" alt="" />
                    <?php endif; ?>
                </div>

                <!-- Text Side -->
                <div class="cta-split-text" style="order: <?php echo esc_attr( $txt_order ); ?>;">
                    <?php if ( ! empty( $title ) ) : ?>
                        <h2 class="navid-section-title" style="color: <?php echo esc_attr( $text_color ); ?>; font-size: <?php echo $h2_calc; ?>;"><?php echo wp_kses_post( $title ); ?></h2>
                    <?php endif; ?>
                    <?php if ( ! empty( $text ) ) : ?>
                        <div class="cta-content">
                            <?php echo wpautop( wp_kses_post( $text ) ); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $btn_text ) && ! empty( $btn_url ) ) : ?>
                        <div>
                            <a href="<?php echo esc_url( $btn_url ); ?>" class="cta-explore-link <?php echo esc_attr( $link_class ); ?>" target="<?php echo esc_attr( $btn_target ); ?>">
                                <?php echo esc_html( $btn_text ); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</section>
