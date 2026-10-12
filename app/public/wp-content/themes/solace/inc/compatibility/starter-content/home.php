<?php
/**
 * Home starter content.
 *
 */

// @codingStandardsIgnoreStart WordPressVIPMinimum.Security.Mustache.OutputNotation -- Required for starter content.
$solace_default_home_content = '<style>.header-main-inner .container,.footer-top-inner .container{width: 70vw;max-width: 70vw;padding-left: 0;padding-right: 0;}.boxes-header{display:none} #mc-embedded-subscribe{background:#3662ff; color: #fff; }

@media only screen and (max-width: 1440px) {
	.header-main-inner .container,
	.footer-top-inner .container {
		width: 80vw;
		max-width: 80vw;
	}

	.boxes-content .the-content>.alignwide,
	.alignwide {
		width: 80vw;
		max-width: 80vw;
		margin-left: calc(50% - 40vw);
	}

	#hero-section .wp-container-core-columns-is-layout-28f84493 .wp-block-column:last-child {
		flex-basis: auto !important;
	}

	#hero-section .wp-container-core-columns-is-layout-19dd641c .wp-block-column {
		height: 98px !important;
	}

	#why-choose-us .wp-container-core-columns-is-layout-e0dca8c8 > .wp-block-column:first-child {
        display: flex !important;
        flex-wrap: wrap !important;
		align-items: center !important;
	}
}

@media only screen and (max-width: 1024px) {
	:root :where(.is-layout-flex) {
		gap: 16px !important;
	}

	h1 {
		font-size: 50px !important;
	}

	h2 {
		font-size: 38px !important;
	}

	h3 {
		font-size: 35px !important;
	}

	h4 {
		font-size: 30px !important;
	}

	h5 {
		font-size: 27px !important;
	}

	h6 {
		font-size: 24px !important;
	}

	img {
		width: 70% !important;
	}

	.has-text-align-left {
		text-align: center !important;
	}	

	.header-main-inner .container,
	.footer-top-inner .container,
	#hero-section,
	#why-choose-us,
	#template,
	#testimonials,
	#faq,
	#business {
	    width: 100% !important;
		max-width: 100% !important;
		margin-left: auto !important;
		margin-right: auto !important;
		margin-top: 80px !important;
		margin-bottom: 80px !important;
		padding-top: 0 !important;
		padding-bottom: 0 !important;
	}

	#hero-section .alignwide,
	#why-choose-us .alignwide,
	#template .alignwide,
	#testimonials .alignwide,
	#faq .alignwide,
	#business .alignwide {
		max-width: 100% !important;
		width: 100% !important;
	}

	.header-main-inner .container,
	.footer-top-inner .container {
		width: 100% !important;
		max-width: 100% !important;
		margin-left: auto !important;
		margin-right: auto !important;
		padding-left: 32px !important;
		padding-right: 32px !important;
	}

	.header-main-inner .container .site-logo img {
		margin-left: 0 !important;
	}

	.header-main-inner .container,
	.footer-top-inner .container {
		margin-top: 0 !important;
		margin-bottom: 0 !important;
	}

	#hero-section {
		padding-top: 0 !important;
		margin-top: 15px !important;
		text-align: center !important;
	}

	#hero-section h1 {
		margin: 16px 0 !important;
	}

	#hero-section .wp-block-buttons {
		justify-content: center !important;
	}

	#hero-section .wp-elements-ee0e25ace96fb60c4b7dff4c74b434f6 {
		font-size: 16px !important;
		margin: 16px 0 !important;
	}

	#hero-section .wp-block-columns.wp-container-core-columns-is-layout-19dd641c {
		margin-top: 16px !important;
	}

	#hero-section img {
		width: 100% !important;
		margin: 16px auto !important;
	}

	#trusted .wp-container-core-columns-is-layout-814f8274 {
		gap: 50px !important;
	}

	#trusted .wp-block-column {
		text-align: center;
	}

	#trusted img {
		width: 40% !important;
	}

	#why-choose-us {
		text-align: center !important;
	}

	#why-choose-us .wp-container-core-columns-is-layout-e0dca8c8 img {
		width: 100% !important;
	}

	#why-choose-us .wp-elements-a149d8bd6de31ea095f54c7e5538bbe3 {
		font-size: 16px !important;
	}

	#why-choose-us .wp-block-column .wp-block-columns .wp-block-column .wp-block-columns .wp-block-column img {
		width: 85px !important;
	}

	#template .alignwide {
		margin-left: 0 !important;
		margin-right: 0 !important;
	}

	#template .wp-elements-cd50005339cd7b7a975bbd1d128d4a94 {
		font-size: 16px !important;
	}

	#template .wp-container-core-group-is-layout-a54c839c {
		padding-left: 0 !important;
		padding-right: 0 !important;
	}

	#testimonials .wp-elements-705929060d417aa591b29e80f5b07f19 {
		font-size: 16px !important
	}

	#testimonials img {
		width: 100% !important;
	}

	#testimonials .wp-block-group.solace-gutenberg-border-color {
		padding-top: 16px !important
		padding-bottom: 16px !important
	}

	#testimonials .wp-block-group.solace-gutenberg-border-color p {
		font-size: 16px !important
	}

	#testimonials .alignwide {
		width: 100% !important;
	}

	#testimonials .solace-gutenberg-width100 > .wp-block-column  {
		padding: 0 !important;
	}

	#testimonials .wp-block-group {
		text-align: center !important;
	}
		
	#testimonials .wp-block-group p {
		width: 100% !important;
	}

	#testimonials .wp-block-group p.has-white-color {
		font-size: 22px !important;
		margin-bottom: 16px !important;
	}

	#faq {
		text-align: center !important;
	}

	#faq .wp-block-group:first-child > .wp-block-columns {
		gap: 0 !important;
	}

	#faq .wp-block-group:first-child > .wp-block-columns .wp-block-column:first-child {
		padding-top: 16px !important;
		padding-bottom: 16px !important;
	}

	#faq .wp-block-group:first-child > .wp-block-columns .wp-block-column:last-child {
		padding-top: 0 !important;
		padding-bottom: 0 !important;
	}

	#faq .wp-block-group .wp-block-group:last-child {
		margin-top: 16px !important;
	}

	#faq .wp-elements-53695cdaf24fcda2e4e8ff4c4340b2ff {
		font-size: 16px !important;
	}

	#faq .wp-block-group:last-child {
		margin-top: 16px !important;
	}

	#faq .wp-container-core-group-is-layout-bcc7562f {
		margin-top: 20px !important;
	}

	#faq summary {
		font-size: 18px !important;
		padding-right: 30px !important;
	}

	#faq .wp-container-core-columns-is-layout-28f84493 .wp-block-column  {
		padding: 0 !important;
	}

	#faq .wp-container-core-group-is-layout-bcc7562f {
	    width: 100% !important;
		max-width: 100% !important;
		margin-left: auto !important;
		margin-right: auto !important;
		margin-top: 50px !important;
		margin-bottom: 50px !important;
		padding-top: 0 !important;
		padding-bottom: 0 !important;
	}

	#faq .wp-container-core-group-is-layout-bcc7562f {
		padding-top: 24px !important;
		text-align: left !important;
	}

	#faq .wp-block-group details {
		text-align: left !important;
	}

	#business img {
		width: 100% !important;
	}

	#business .wp-block-cover {
		padding-top: 0 !important;
		padding-bottom: 0 !important;
	}

	.solace-gutenberg-background-color-overlay::before {
		max-width: 200% !important;
		width: 200% !important;
	}

	#business .wp-elements-3cc27d0948779a9ef424e6333ee9bb2c {
		font-size: 16px !important;
		margin-bottom: 16px !important;
	}

	#business img {
        width: 100% !important;
        height: 100% !important;
    }	

	.footer--row .my-row-inner {
		padding: 16px 0 !important;
	}	
}

@media only screen and (max-width: 576px) {
	#hero-section,
	#why-choose-us,
	#template,
	#testimonials,
	#faq,
	#business {
		margin-top: 40px !important;
		margin-bottom: 40px !important;
	}

	.header-main-inner .container .hfg-slot left .builder-item tablet-center.mobile-center {
		padding-left: 0;
	}

	.header-main-inner .container .builder-item {
		padding-right: 0;
		padding-left: 0;
	}

	#trusted .wp-container-core-columns-is-layout-814f8274 {
		gap: 20px;
	}

	#why-choose-us .wp-container-core-columns-is-layout-e0dca8c8 .why-choose-us-img {
		width: 90% !important;
	}

	.solace-gutenberg-box-shadow,
	#testimonials {
		padding: 20px !important;
	}

	#testimonials .wp-container-core-columns-is-layout-df0ecb7a .wp-block-column-is-layout-flow {
		padding-left: 20px !important;
		padding-right: 20px !important;
	}

	#testimonials {
		padding: 0 !important;
	}

	#testimonials .wp-container-core-columns-is-layout-28f84493 .wp-block-column {
		padding-bottom: 0 !important;
	}

	#testimonials .wp-container-core-group-is-layout-96c921a5 {
		padding: 20px !important;
	}

	#faq .wp-container-core-group-is-layout-bcc7562f {
		margin-top: 20px !important;
	}

	#faq .wp-container-core-group-is-layout-bcc7562f {
		padding: 20px !important;
	}

	#business img {
        width: 100% !important;
        height: 100% !important;
    }
}

</style><script>(function(){function getOffset(){var v=getComputedStyle(document.documentElement).getPropertyValue("--solace-sticky-offset");var n=parseInt(v,10);return isNaN(n)?100:n}function smoothTo(hash){if(!hash)return;var id=hash.replace("#",""),el=document.getElementById(id)||document.querySelector(hash);if(!el)return;var top=el.getBoundingClientRect().top+window.pageYOffset-getOffset();window.scrollTo({top:top,behavior:"smooth"})}document.addEventListener("click",function(e){var a=e.target.closest("a[href^=\"#\"]");if(!a)return;e.preventDefault();smoothTo(a.hash||a.getAttribute("href"))},{passive:false});})();</script><!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"bottom":"160px"},"padding":{"top":"54px"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignwide" id="hero-section" style="margin-bottom:160px;padding-top:54px"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"600px"} -->
<div class="wp-block-column" style="flex-basis:600px"><!-- wp:paragraph {"style":{"color":{"text":"#ff8c00"},"elements":{"link":{"color":{"text":"#ff8c00"}}},"typography":{"fontSize":"16px"}}} -->
<p class="has-text-color has-link-color" style="color:#ff8c00;font-size:16px">Transforming ideas into reality</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"94px","fontStyle":"normal","fontWeight":"1000","textTransform":"capitalize","lineHeight":"1"},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"spacing":{"margin":{"top":"16px","bottom":"32px"}}},"fontFamily":"dm-sans"} -->
<h1 class="wp-block-heading has-text-color has-link-color has-dm-sans-font-family" style="color:#1f2937;margin-top:16px;margin-bottom:32px;font-size:94px;font-style:normal;font-weight:900;line-height:1;text-transform:capitalize">Transform Your Online Presence.</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"24px"},"color":{"text":"#374151"},"elements":{"link":{"color":{"text":"#374151"}}},"spacing":{"margin":{"bottom":"8px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#374151;margin-bottom:8px;font-size:24px">Reveal the ultimate WordPress theme that’s lightweight, modifiable, and user-friendly.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"fontFamily":"dm-sans"} -->
<div class="wp-block-buttons has-dm-sans-font-family"><!-- wp:button {"textColor":"white","style":{"spacing":{"padding":{"left":"24px","right":"24px","top":"12px","bottom":"12px"}},"color":{"background":"#3662ff"},"border":{"radius":"8px"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background has-link-color wp-element-button" style="border-radius:8px;background-color:#3662ff;padding-top:12px;padding-right:24px;padding-bottom:12px;padding-left:24px">Get a Quote</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"margin":{"top":"56px"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center" style="margin-top:56px"><!-- wp:column {"verticalAlignment":"center","width":"217px"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:217px"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontSize":"28px","fontStyle":"normal","fontWeight":"1000"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"8px","left":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="margin-top:0px;margin-right:0px;margin-bottom:8px;margin-left:0px;font-size:28px;font-style:normal;font-weight:900">4,652</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"left","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-left has-dm-sans-font-family" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">Clients</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"217px"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:217px"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontSize":"28px","fontStyle":"normal","fontWeight":"1000"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"8px","left":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="margin-top:0px;margin-right:0px;margin-bottom:8px;margin-left:0px;font-size:28px;font-style:normal;font-weight:900">27,525</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"left","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-left has-dm-sans-font-family" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">Completed Projects</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"217px","style":{"spacing":{"blockGap":"0px"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:217px"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"fontSize":"28px","fontStyle":"normal","fontWeight":"1000"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"8px","left":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="margin-top:0px;margin-right:0px;margin-bottom:8px;margin-left:0px;font-size:28px;font-style:normal;font-weight:900">25y</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"left","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-left has-dm-sans-font-family" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">Journey Experiences</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"><!-- wp:image {"id":1792,"scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"55px"}}} -->
<figure class="wp-block-image size-full has-custom-border"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/hero-image.png" alt="" class="wp-image-1792" style="border-radius:55px;object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"32px","bottom":"32px"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignwide" id="trusted" style="margin-top:32px;margin-bottom:32px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ff8c00"},"elements":{"link":{"color":{"text":"#ff8c00"}}},"typography":{"fontSize":"16px"},"spacing":{"margin":{"bottom":"30px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-center has-text-color has-link-color has-dm-sans-font-family" style="color:#ff8c00;margin-bottom:30px;font-size:16px">Trusted by reputable companies</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"128px","left":"128px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"140px"} -->
<div class="wp-block-column" style="flex-basis:140px"><!-- wp:image {"id":1971,"scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/brand1.png" alt="" class="wp-image-1971" style="object-fit:cover"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"140px"} -->
<div class="wp-block-column" style="flex-basis:140px"><!-- wp:image {"id":1703,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/brand2.png" alt="" class="wp-image-1703"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"140px"} -->
<div class="wp-block-column" style="flex-basis:140px"><!-- wp:image {"id":1704,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/brand3.png" alt="" class="wp-image-1704"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"140px"} -->
<div class="wp-block-column" style="flex-basis:140px"><!-- wp:image {"id":1705,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/brand4.png" alt="" class="wp-image-1705"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"140px"} -->
<div class="wp-block-column" style="flex-basis:140px"><!-- wp:image {"id":1706,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/brand5.png" alt="" class="wp-image-1706"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"3px","margin":{"top":"160px","bottom":"128px"}}},"layout":{"type":"constrained","justifyContent":"center","wideSize":"","contentSize":"1280px"}} -->
<div class="wp-block-group alignwide" id="why-choose-us" style="margin-top:160px;margin-bottom:128px"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"32px","left":"32px"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"35%"} -->
<div class="wp-block-column" style="flex-basis:35%"><!-- wp:image {"id":1821,"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"8px"}}} -->
<figure class="wp-block-image size-full has-custom-border"><img class="why-choose-us-img" src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/why-choose-us.png" alt="" class="wp-image-1821" style="border-radius:8px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"681px","style":{"spacing":{"padding":{"top":"32px","bottom":"0px","right":"32px","left":"0px"}}}} -->
<div class="wp-block-column" style="padding-top:32px;padding-right:32px;padding-bottom:0px;padding-left:0px;flex-basis:681px"><!-- wp:paragraph {"align":"left","style":{"color":{"text":"#ff8c00"},"elements":{"link":{"color":{"text":"#ff8c00"}}},"typography":{"fontSize":"16px"},"spacing":{"margin":{"bottom":"16px","top":"0px","left":"0px","right":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-left has-text-color has-link-color has-dm-sans-font-family" style="color:#ff8c00;margin-top:0px;margin-right:0px;margin-bottom:16px;margin-left:0px;font-size:16px">Why choose us</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"typography":{"fontSize":"48px","fontStyle":"normal","fontWeight":"1000","textTransform":"capitalize"},"spacing":{"margin":{"bottom":"16px","top":"0px"}}},"fontFamily":"dm-sans"} -->
<h2 class="wp-block-heading has-dm-sans-font-family" style="margin-top:0px;margin-bottom:16px;font-size:48px;font-style:normal;font-weight:900;text-transform:capitalize">Precision &amp; innovation</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"24px"},"color":{"text":"#374151"},"elements":{"link":{"color":{"text":"#374151"}}},"spacing":{"margin":{"bottom":"40px","top":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#374151;margin-top:0px;margin-bottom:40px;font-size:24px">We create thousands of template with hight quality and modern features that fit with any business field</p>
<!-- /wp:paragraph -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"24px","left":"24px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"px","style":{"spacing":{"blockGap":"15px"}}} -->
<div class="wp-block-column"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"15px","left":"15px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"70px"} -->
<div class="wp-block-column" style="flex-basis:70px"><!-- wp:image {"id":1823,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/responsive-design.png" alt="" class="wp-image-1823"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"900","lineHeight":"1.3"},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"spacing":{"margin":{"bottom":"8px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#1f2937;margin-bottom:8px;font-size:22px;font-style:normal;font-weight:900;line-height:1.3"><strong>Responsive Design</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px"}}}} -->
<p style="margin-top:0px;font-size:16px">Solace responsive design adapts to screens of all sizes for optimal viewing.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"","style":{"spacing":{"blockGap":"15px"}}} -->
<div class="wp-block-column"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"15px","left":"15px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"70px"} -->
<div class="wp-block-column" style="flex-basis:70px"><!-- wp:image {"id":1826,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Global-Color-Palette.png" alt="" class="wp-image-1826"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"900","lineHeight":"1.3"},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"spacing":{"margin":{"bottom":"8px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#1f2937;margin-bottom:8px;font-size:22px;font-style:normal;font-weight:900;line-height:1.3"><strong>Global Color Palette</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px"}}}} -->
<p style="margin-top:0px;font-size:16px">Use the global color palette to easily align your site’s design with your brand.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"24px","left":"24px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"px","style":{"spacing":{"blockGap":"15px"}}} -->
<div class="wp-block-column"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"15px","left":"15px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"70px"} -->
<div class="wp-block-column" style="flex-basis:70px"><!-- wp:image {"id":1828,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Translation-Ready.png" alt="" class="wp-image-1828"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"900","lineHeight":"1.3"},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"spacing":{"margin":{"bottom":"8px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#1f2937;margin-bottom:8px;font-size:22px;font-style:normal;font-weight:900;line-height:1.3"><strong>Translation Ready</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px"}}}} -->
<p style="margin-top:0px;font-size:16px">Make your content accessible to users around the world.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"","style":{"spacing":{"blockGap":"15px"}}} -->
<div class="wp-block-column"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"15px","left":"15px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"70px"} -->
<div class="wp-block-column" style="flex-basis:70px"><!-- wp:image {"id":1830,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Blog-Page-Setting.png" alt="" class="wp-image-1830"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"900","lineHeight":"1.3"},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"spacing":{"margin":{"bottom":"8px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#1f2937;margin-bottom:8px;font-size:22px;font-style:normal;font-weight:900;line-height:1.3"><strong>Blog Page Setting</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px"}}}} -->
<p style="margin-top:0px;font-size:16px">Customize settings to display posts in a layout that resonates with audience.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide", class="solace-gutenberg-full-width","style":{"background":{"backgroundImage":{"url":"' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/decoration.png","id":1962,"source":"file","title":"decoration"},"backgroundSize":"contain","backgroundRepeat":"no-repeat"},"spacing":{"padding":{"bottom":"0px"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignwide" id="template" style="padding-bottom:0px"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"100%"} -->
<div class="wp-block-column" style="flex-basis:100%"><!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","bottom":"32px","right":"32px","left":"32px"}}},"layout":{"type":"constrained","contentSize":"595px"}} -->
<div class="wp-block-group" style="padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ff8c00"},"elements":{"link":{"color":{"text":"#ff8c00"}}},"typography":{"fontSize":"16px"},"spacing":{"margin":{"bottom":"16px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-center has-text-color has-link-color has-dm-sans-font-family" style="color:#ff8c00;margin-bottom:16px;font-size:16px">Template categories</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"48px","fontStyle":"normal","fontWeight":"900"},"color":{"text":"#1f2937"},"spacing":{"margin":{"bottom":"16px","top":"0px"}}},"fontFamily":"dm-sans"} -->
<h2 class="wp-block-heading has-text-align-center has-text-color has-dm-sans-font-family" style="color:#1f2937;margin-top:0px;margin-bottom:16px;font-size:48px;font-style:normal;font-weight:900">Designs for every need</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"24px"},"color":{"text":"#374151"},"elements":{"link":{"color":{"text":"#374151"}}},"spacing":{"margin":{"bottom":"0px","top":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-center has-text-color has-link-color has-dm-sans-font-family" style="color:#374151;margin-top:0px;margin-bottom:0px;font-size:24px">Each design is optimized for usability and efficiency, ensuring an ideal fit for your project.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"0px","left":"32px"},"margin":{"top":"0px","bottom":"0px"},"blockGap":"48px"}},"layout":{"type":"constrained","contentSize":"1216px"}} -->
<div class="wp-block-group alignwide" style="margin-top:0px;margin-bottom:0px;padding-top:32px;padding-bottom:0px;"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"48px","left":"48px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"","className":"solace-gutenberg-box-shadow","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}},"backgroundColor":"white"} -->
<div class="wp-block-column solace-gutenberg-box-shadow has-white-background-color has-background" style="border-radius:12px;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:image {"id":1833,"sizeSlug":"full","linkDestination":"none","align":"center","style":{"spacing":{"margin":{"bottom":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full" style="margin-bottom:15px"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/E-commerce.png" alt="" class="wp-image-1833"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"color":{"text":"#3662ff"},"elements":{"link":{"color":{"text":"#3662ff"}}},"spacing":{"margin":{"top":"0px","bottom":"16px"}}}} -->
<p class="has-text-align-center has-text-color has-link-color" style="color:#3662ff;margin-top:0px;margin-bottom:16px;font-size:22px;font-style:normal;font-weight:900"><strong>E-commerce</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} -->
<p class="has-text-align-center" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">Designed to enhance user experience, these templates come with built-in features for easy product management</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"","className":"solace-gutenberg-box-shadow","style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}},"color":{"background":"#3662ff"},"border":{"radius":"12px"}}} -->
<div class="wp-block-column solace-gutenberg-box-shadow has-background" style="border-radius:12px;background-color:#3662ff;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:image {"id":1836,"sizeSlug":"full","linkDestination":"none","align":"center","style":{"spacing":{"margin":{"bottom":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full" style="margin-bottom:15px"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Real-Estate.png" alt="" class="wp-image-1836"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"margin":{"bottom":"16px"}}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color has-link-color" style="margin-bottom:16px;font-size:22px;font-style:normal;font-weight:900"><strong>Real Estate</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color has-link-color" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">These designs offer elegant layouts, integrated map views, and powerful search functionality</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"","className":"solace-gutenberg-box-shadow","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}},"backgroundColor":"white"} -->
<div class="wp-block-column solace-gutenberg-box-shadow has-white-background-color has-background" style="border-radius:12px;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:image {"id":1838,"sizeSlug":"full","linkDestination":"none","align":"center","style":{"spacing":{"margin":{"bottom":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full" style="margin-bottom:15px"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Technology.png" alt="" class="wp-image-1838"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"color":{"text":"#3662ff"},"elements":{"link":{"color":{"text":"#3662ff"}}},"spacing":{"margin":{"bottom":"16px"}}}} -->
<p class="has-text-align-center has-text-color has-link-color" style="color:#3662ff;margin-bottom:16px;font-size:22px;font-style:normal;font-weight:900"><strong>Technology</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} -->
<p class="has-text-align-center" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">Perfect for tech companies, startups, and IT services, these templates feature modern designs, interactive elements</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"48px","left":"48px"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"","className":"solace-gutenberg-box-shadow","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}},"backgroundColor":"white"} -->
<div class="wp-block-column solace-gutenberg-box-shadow has-white-background-color has-background" style="border-radius:12px;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:image {"id":1840,"sizeSlug":"full","linkDestination":"none","align":"center","style":{"spacing":{"margin":{"bottom":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full" style="margin-bottom:15px"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Corporate.png" alt="" class="wp-image-1840"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"color":{"text":"#3662ff"},"elements":{"link":{"color":{"text":"#3662ff"}}},"spacing":{"margin":{"bottom":"16px"}}}} -->
<p class="has-text-align-center has-text-color has-link-color" style="color:#3662ff;margin-bottom:16px;font-size:22px;font-style:normal;font-weight:900"><strong>Corporate</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} -->
<p class="has-text-align-center" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">These designs are tailored for companies of all sizes, offering clean layouts, and customizable sections</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"","className":"solace-gutenberg-box-shadow","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}},"backgroundColor":"white"} -->
<div class="wp-block-column solace-gutenberg-box-shadow has-white-background-color has-background" style="border-radius:12px;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:image {"id":1842,"sizeSlug":"full","linkDestination":"none","align":"center","style":{"spacing":{"margin":{"bottom":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full" style="margin-bottom:15px"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Events.png" alt="" class="wp-image-1842"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"color":{"text":"#3662ff"},"elements":{"link":{"color":{"text":"#3662ff"}}},"spacing":{"margin":{"bottom":"16px"}}}} -->
<p class="has-text-align-center has-text-color has-link-color" style="color:#3662ff;margin-bottom:16px;font-size:22px;font-style:normal;font-weight:900"><strong>Events</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} -->
<p class="has-text-align-center" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">Ideal for conferences, weddings, parties, and more, these templates include and customisable event schedules</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"","className":"solace-gutenberg-box-shadow","style":{"border":{"radius":"12px"},"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}},"backgroundColor":"white"} -->
<div class="wp-block-column solace-gutenberg-box-shadow has-white-background-color has-background" style="border-radius:12px;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:image {"id":1845,"sizeSlug":"full","linkDestination":"none","align":"center","style":{"spacing":{"margin":{"bottom":"15px"}}}} -->
<figure class="wp-block-image aligncenter size-full" style="margin-bottom:15px"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/Education.png" alt="" class="wp-image-1845"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"color":{"text":"#3662ff"},"elements":{"link":{"color":{"text":"#3662ff"}}},"spacing":{"margin":{"bottom":"16px"}}}} -->
<p class="has-text-align-center has-text-color has-link-color" style="color:#3662ff;margin-bottom:16px;font-size:22px;font-style:normal;font-weight:900"><strong>Education</strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"0px","left":"0px"}}}} -->
<p class="has-text-align-center" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;font-size:16px">Whether for schools, universities, or online courses, these designs provide user-friendly interfaces</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"solace-gutenberg-right-2","style":{"spacing":{"margin":{"top":"128px"},"padding":{"top":"96px","bottom":"96px"}}},"backgroundColor":"black","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignfull solace-gutenberg-right-2 has-black-background-color has-background" id="testimonials" style="margin-top:128px;padding-top:96px;padding-bottom:96px"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"100%","style":{"spacing":{"padding":{"top":"32px","bottom":"32px"}}}} -->
<div class="wp-block-column" style="padding-top:32px;padding-bottom:32px;flex-basis:100%"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#3662ff"},"elements":{"link":{"color":{"text":"#3662ff"}}},"typography":{"fontSize":"16px"},"spacing":{"margin":{"bottom":"16px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-center has-text-color has-link-color has-dm-sans-font-family" style="color:#3662ff;margin-bottom:16px;font-size:16px">Testimonials</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"48px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"1000"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"margin":{"top":"0px","bottom":"16px"}}},"textColor":"white","fontFamily":"dm-sans"} -->
<h2 class="wp-block-heading has-text-align-center has-white-color has-text-color has-link-color has-dm-sans-font-family" style="margin-top:0px;margin-bottom:16px;font-size:48px;font-style:normal;font-weight:900;text-transform:capitalize">Your perfect template author partner</h2>
<!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"constrained","contentSize":"596px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"24px"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"margin":{"bottom":"0px","top":"0px"}}},"textColor":"white","fontFamily":"dm-sans"} -->
<p class="has-text-align-center has-white-color has-text-color has-link-color has-dm-sans-font-family" style="margin-top:0px;margin-bottom:0px;font-size:24px">Discover the experiences of our satisfied customers who’ve seen their ideas come to life with Solace.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide","className":"solace-gutenberg-width100","style":{"spacing":{"blockGap":{"top":"0px","left":"0px"},"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"},"margin":{"top":"0px","bottom":"0px"}}}} -->
<div class="wp-block-columns alignwide solace-gutenberg-width100" style="margin-top:0px;margin-bottom:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:column {"width":"","style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}}} -->
<div class="wp-block-column" style="padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:image {"id":20,"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"12px"},"spacing":{"margin":{"top":"32px"}}}} -->
<figure class="wp-block-image size-full has-custom-border" style="margin-top:32px"><img src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/john-smith.png" alt="" class="wp-image-20" style="border-radius:12px"/></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"","style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}}} -->
<div class="wp-block-column" style="padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:group {"className":"solace-gutenberg-border-color","style":{"border":{"bottom":{"color":"var:preset|color|white","width":"1px"},"top":[],"right":[],"left":[]},"spacing":{"padding":{"bottom":"31px","top":"16px"},"blockGap":"0px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group solace-gutenberg-border-color" style="border-bottom-color:var(--wp--preset--color--white);border-bottom-width:1px;padding-top:16px;padding-bottom:31px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"spacing":{"margin":{"bottom":"40px"}}},"textColor":"white","fontFamily":"dm-sans"} -->
<p class="has-white-color has-text-color has-link-color has-dm-sans-font-family" style="margin-bottom:40px;font-size:22px;font-style:normal;font-weight:900">“Solace’s templates are a game-changer. They are not only visually appealing but also incredibly easy to customize. Our website now looks professional and inviting.”</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"left","style":{"elements":{"link":{"color":{"text":"#3662ff"}}},"color":{"text":"#3662ff"},"typography":{"fontStyle":"normal","fontWeight":"1000","fontSize":"22px"},"spacing":{"margin":{"bottom":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-left has-text-color has-link-color has-dm-sans-font-family" style="color:#3662ff;margin-bottom:0px;font-size:22px;font-style:normal;font-weight:900">Michael Lean</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"typography":{"fontSize":"16px"}},"textColor":"white"} -->
<p class="has-white-color has-text-color has-link-color" style="font-size:16px">MECHANICAL ENGINEER</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"solace-gutenberg-border-color","style":{"border":{"top":[],"right":[],"bottom":{"color":"var:preset|color|white","width":"1px"},"left":[]},"spacing":{"padding":{"bottom":"31px","top":"16px"},"blockGap":"0px","margin":{"top":"0px"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group solace-gutenberg-border-color" style="border-bottom-color:var(--wp--preset--color--white);border-bottom-width:1px;margin-top:0px;padding-top:16px;padding-bottom:31px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"spacing":{"margin":{"bottom":"40px"}}},"textColor":"white","fontFamily":"dm-sans"} -->
<p class="has-white-color has-text-color has-link-color has-dm-sans-font-family" style="margin-bottom:40px;font-size:22px;font-style:normal;font-weight:900">“As a web developer, I’ve used many templates, but Solace stands out for its quality and flexibility. The support team is also fantastic, helping me tailor the template.”</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#3662ff"}}},"color":{"text":"#3662ff"},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"spacing":{"margin":{"bottom":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#3662ff;margin-bottom:0px;font-size:22px;font-style:normal;font-weight:900">Sarah Grealish</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"typography":{"fontSize":"16px"}},"textColor":"white"} -->
<p class="has-white-color has-text-color has-link-color" style="font-size:16px">PRODUCT DESIGNER</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"solace-gutenberg-border-color","style":{"border":{"bottom":{"color":"var:preset|color|white","width":"1px"},"top":[],"right":[],"left":[]},"spacing":{"padding":{"bottom":"31px","top":"16px"},"blockGap":"0px","margin":{"top":"0px"}}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group solace-gutenberg-border-color" style="border-bottom-color:var(--wp--preset--color--white);border-bottom-width:1px;margin-top:0px;padding-top:16px;padding-bottom:31px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"spacing":{"margin":{"bottom":"40px"}}},"textColor":"white","fontFamily":"dm-sans"} -->
<p class="has-white-color has-text-color has-link-color has-dm-sans-font-family" style="margin-bottom:40px;font-size:22px;font-style:normal;font-weight:900">“I was able to create a beautiful, functional website with minimal effort thanks to Solace. The templates are intuitive and versatile, perfect for someone like me.”</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#3662ff"}}},"color":{"text":"#3662ff"},"typography":{"fontStyle":"normal","fontWeight":"1000","fontSize":"22px"},"spacing":{"margin":{"bottom":"0px"}}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#3662ff;margin-bottom:0px;font-size:22px;font-style:normal;font-weight:900">Mark Johnson</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"typography":{"fontSize":"16px"}},"textColor":"white"} -->
<p class="has-white-color has-text-color has-link-color" style="font-size:16px">Architect</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"faq"},"align":"wide","style":{"spacing":{"padding":{"top":"96px","bottom":"96px"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignwide" id="faq" style="padding-top:96px;padding-bottom:96px"><!-- wp:group {"align":"wide","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignwide"><!-- wp:columns {"verticalAlignment":null} -->
<div class="wp-block-columns"><!-- wp:column {"style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}}} -->
<div class="wp-block-column" style="padding-top:32px;padding-bottom:32px;"><!-- wp:paragraph {"style":{"color":{"text":"#3662ff"},"elements":{"link":{"color":{"text":"#3662ff"}}},"spacing":{"margin":{"bottom":"16px"}},"typography":{"fontSize":"16px"}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#3662ff;margin-bottom:16px;font-size:16px">FAQ</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"style":{"typography":{"fontSize":"48px","fontStyle":"normal","fontWeight":"1000"},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}}},"fontFamily":"dm-sans"} -->
<h2 class="wp-block-heading has-text-color has-link-color has-dm-sans-font-family" style="color:#1f2937;font-size:48px;font-style:normal;font-weight:900">Frequently asked questions</h2>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"bottom","style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}}}} -->
<div class="wp-block-column is-vertically-aligned-bottom" style="padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"#374151"}}},"color":{"text":"#374151"},"typography":{"fontSize":"24px"}},"fontFamily":"dm-sans"} -->
<p class="has-text-color has-link-color has-dm-sans-font-family" style="color:#374151;font-size:24px">Explore answers to frequently asked questions about our WordPress template kit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"},"margin":{"top":"32px","bottom":"32px"}},"color":{"background":"#d9e2f7"},"border":{"radius":"12px"}},"layout":{"type":"constrained","contentSize":"1216px"}} -->
<div class="wp-block-group alignwide has-background" style="border-radius:12px;background-color:#d9e2f7;margin-top:32px;margin-bottom:32px;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:details {"className":"solace-gutenberg-summary","style":{"spacing":{"margin":{"top":"0px","bottom":"16px","left":"0px","right":"0px"},"padding":{"top":"8px","bottom":"24px"}},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"border":{"bottom":{"color":"#e5ebf8","width":"1px"}}},"fontFamily":"dm-sans"} -->
<details class="wp-block-details solace-gutenberg-summary has-text-color has-link-color has-dm-sans-font-family" style="border-bottom-color:#e5ebf8;border-bottom-width:1px;color:#1f2937;margin-top:0px;margin-right:0px;margin-bottom:16px;margin-left:0px;padding-top:8px;padding-bottom:24px;font-size:22px;font-style:normal;font-weight:900"><summary>What types of WordPress templates do you offer?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block","style":{"spacing":{"padding":{"top":"16px","bottom":"8px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="padding-top:16px;padding-bottom:8px;font-size:16px;font-style:normal;font-weight:400">We offer a wide range of WordPress templates, including themes for blogs, e-commerce stores, business websites, portfolios, and more. Our templates are designed to be versatile and customizable to meet various needs.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"solace-gutenberg-summary","style":{"spacing":{"margin":{"top":"0px","bottom":"16px","left":"0px","right":"0px"},"padding":{"top":"8px","bottom":"24px"}},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"border":{"bottom":{"color":"#e5ebf8","width":"1px"}}},"fontFamily":"dm-sans"} -->
<details class="wp-block-details solace-gutenberg-summary has-text-color has-link-color has-dm-sans-font-family" style="border-bottom-color:#e5ebf8;border-bottom-width:1px;color:#1f2937;margin-top:0px;margin-right:0px;margin-bottom:16px;margin-left:0px;padding-top:8px;padding-bottom:24px;font-size:22px;font-style:normal;font-weight:900"><summary>Are your templates responsive and mobile-friendly?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block","style":{"spacing":{"padding":{"top":"16px","bottom":"8px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="padding-top:16px;padding-bottom:8px;font-size:16px;font-style:normal;font-weight:400">Yes, all our templates are fully responsive and mobile-friendly. They are designed to look great on any device, ensuring a seamless user experience across desktops, tablets, and smartphones.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"solace-gutenberg-summary","style":{"spacing":{"margin":{"top":"0px","bottom":"16px","left":"0px","right":"0px"},"padding":{"top":"8px","bottom":"24px"}},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"border":{"bottom":{"color":"#e5ebf8","width":"1px"}}},"fontFamily":"dm-sans"} -->
<details class="wp-block-details solace-gutenberg-summary has-text-color has-link-color has-dm-sans-font-family" style="border-bottom-color:#e5ebf8;border-bottom-width:1px;color:#1f2937;margin-top:0px;margin-right:0px;margin-bottom:16px;margin-left:0px;padding-top:8px;padding-bottom:24px;font-size:22px;font-style:normal;font-weight:900"><summary>Can I customize the templates to match my branding?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block","style":{"spacing":{"padding":{"top":"16px","bottom":"8px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="padding-top:16px;padding-bottom:8px;font-size:16px;font-style:normal;font-weight:400">Absolutely! Our templates are highly customizable. You can change colors, fonts, layouts, and other design elements using the built-in customization options. Many of our templates also support popular page builders for even more flexibility.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"solace-gutenberg-summary","style":{"spacing":{"margin":{"top":"0px","bottom":"16px","left":"0px","right":"0px"},"padding":{"top":"8px","bottom":"24px"}},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"border":{"bottom":{"color":"#e5ebf8","width":"1px"}}},"fontFamily":"dm-sans"} -->
<details class="wp-block-details solace-gutenberg-summary has-text-color has-link-color has-dm-sans-font-family" style="border-bottom-color:#e5ebf8;border-bottom-width:1px;color:#1f2937;margin-top:0px;margin-right:0px;margin-bottom:16px;margin-left:0px;padding-top:8px;padding-bottom:24px;font-size:22px;font-style:normal;font-weight:900"><summary>Are your templates compatible with the latest version of WordPress?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block","style":{"spacing":{"padding":{"top":"16px","bottom":"8px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="padding-top:16px;padding-bottom:8px;font-size:16px;font-style:normal;font-weight:400">Yes, we ensure that all our templates are compatible with the latest version of WordPress. We regularly update our templates to maintain compatibility and incorporate new features and improvements.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"solace-gutenberg-summary","style":{"spacing":{"margin":{"top":"0px","bottom":"16px","left":"0px","right":"0px"},"padding":{"top":"8px","bottom":"24px"}},"color":{"text":"#1f2937"},"elements":{"link":{"color":{"text":"#1f2937"}}},"typography":{"fontSize":"22px","fontStyle":"normal","fontWeight":"1000"},"border":{"bottom":{"color":"#e5ebf8","width":"1px"}}},"fontFamily":"dm-sans"} -->
<details class="wp-block-details solace-gutenberg-summary has-text-color has-link-color has-dm-sans-font-family" style="border-bottom-color:#e5ebf8;border-bottom-width:1px;color:#1f2937;margin-top:0px;margin-right:0px;margin-bottom:16px;margin-left:0px;padding-top:8px;padding-bottom:24px;font-size:22px;font-style:normal;font-weight:900"><summary>How do I receive updates for my purchased templates?</summary><!-- wp:paragraph {"placeholder":"Type / to add a hidden block","style":{"spacing":{"padding":{"top":"16px","bottom":"8px"}},"typography":{"fontSize":"16px","fontStyle":"normal","fontWeight":"400"}},"fontFamily":"dm-sans"} -->
<p class="has-dm-sans-font-family" style="padding-top:16px;padding-bottom:8px;font-size:16px;font-style:normal;font-weight:400">Once you purchase a template, you will receive notifications about updates. You can download the latest version from your account on our website. Keeping your templates updated ensures you have the latest features and security improvements.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"wide","className":"solace-gutenberg-right-2 solace-gutenberg-background-color-overlay","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignwide solace-gutenberg-right-2 solace-gutenberg-background-color-overlay" id="business"><!-- wp:cover {"url":"' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/working-1024x732.jpg","id":1764,"dimRatio":30,"customOverlayColor":"#868280","isUserOverlayColor":false,"minHeight":66,"minHeightUnit":"vh","isDark":false,"sizeSlug":"large","metadata":{"categories":["banner"],"patternName":"core/cover-image-with-bold-heading-and-button","name":"Cover Image with Bold Heading and Button"},"align":"full","style":{"spacing":{"padding":{"top":"96px","bottom":"96px"},"margin":{"top":"0"}},"color":{"duotone":"unset"}}} -->
<div class="wp-block-cover alignfull is-light" style="margin-top:0;padding-top:96px;padding-bottom:96px;min-height:66vh"><img class="wp-block-cover__image-background wp-image-1764 size-large" alt="" src="' . trailingslashit( get_template_directory_uri() ) . 'assets/img/starter-content/working-1024x732.jpg" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim-30 has-background-dim" style="background-color:#868280"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"solace-gutenberg-z-index-99","style":{"spacing":{"blockGap":"48px","padding":{"top":"32px","bottom":"32px"}}},"layout":{"type":"constrained","wideSize":"80%"}} -->
<div class="wp-block-group solace-gutenberg-z-index-99" style="padding-top:32px;padding-bottom:32px"><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ff8c00"},"elements":{"link":{"color":{"text":"#ff8c00"}}},"spacing":{"margin":{"top":"0px","right":"0px","bottom":"16px","left":"0px"}},"typography":{"fontSize":"16px"}},"fontFamily":"dm-sans"} -->
<p class="has-text-align-center has-text-color has-link-color has-dm-sans-font-family" style="color:#ff8c00;margin-top:0px;margin-right:0px;margin-bottom:16px;margin-left:0px;font-size:16px">Let"s show your business</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontSize":"48px","textTransform":"capitalize","fontStyle":"normal","fontWeight":"1000","letterSpacing":"0px"},"spacing":{"margin":{"bottom":"16px","top":"0px"}}},"textColor":"white"} -->
<h2 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="margin-top:0px;margin-bottom:16px;font-size:48px;font-style:normal;font-weight:900;letter-spacing:0px;text-transform:capitalize">Turn imagination into reality</h2>
<!-- /wp:heading -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"0px"}}},"layout":{"type":"constrained","contentSize":"595px"}} -->
<div class="wp-block-group" style="margin-top:0px"><!-- wp:paragraph {"align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"typography":{"fontSize":"24px"},"spacing":{"margin":{"bottom":"40px","top":"0px"}}},"textColor":"white"} -->
<p class="has-text-align-center has-white-color has-text-color has-link-color" style="margin-top:0px;margin-bottom:40px;font-size:24px">Unlock Solace’s advanced features and take your WordPress site to the next level.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons" style="margin-top:0px;margin-bottom:0px"><!-- wp:button {"textColor":"white","style":{"spacing":{"padding":{"left":"24px","right":"24px","top":"12px","bottom":"12px"}},"color":{"background":"#3662ff"},"border":{"radius":"8px"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-text-color has-background has-link-color wp-element-button" style="border-radius:8px;background-color:#3662ff;padding-top:12px;padding-right:24px;padding-bottom:12px;padding-left:24px">Get a Quote</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->';

// @codingStandardsIgnoreEnd WordPressVIPMinimum.Security.Mustache.OutputNotation -- Required for starter content.
return array(
	'post_type'    => 'page',
	'post_title'   => _x( 'Home', 'Theme starter content', 'solace' ),
	'post_content' => $solace_default_home_content,
);
