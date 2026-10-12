<?php
/**
 * Test file not part of the project
 *
 * @package HFG
 */
$header_components = array(
	'HFG\Core\Components\Logo',
	'HFG\Core\Components\MenuIcon',
	'HFG\Core\Components\Nav',
	'HFG\Core\Components\Button',
	'HFG\Core\Components\HeaderHtml1',
	// 'HFG\Core\Components\PaletteSwitch',
	'HFG\Core\Components\Search',
	'HFG\Core\Components\SearchResponsive',
	'HFG\Core\Components\SecondNav',
	'HFG\Core\Components\Account',
	'HFG\Core\Components\HeaderContact',
	'HFG\Core\Components\HeaderSocial',
	'HFG\Core\Components\HeaderWidget',
	'HFG\Core\Components\HeaderButton2',
);

$footer_components = array(
	'HFG\Core\Components\LogoFooter',
	'HFG\Core\Components\FooterWidgetOne',
	'HFG\Core\Components\FooterWidgetTwo',
	'HFG\Core\Components\FooterWidgetThree',
	'HFG\Core\Components\FooterWidgetFour',
	'HFG\Core\Components\NavFooter',
	'HFG\Core\Components\CopyrightHtml',
	'HFG\Core\Components\FooterHtml1',
	'HFG\Core\Components\FooterHtml2',
	'HFG\Core\Components\FooterHtml3',
	'HFG\Core\Components\FooterHtml4',
	'HFG\Core\Components\FooterSearch',
	'HFG\Core\Components\FooterAccount',
	'HFG\Core\Components\FooterContact',
	'HFG\Core\Components\FooterSocial',
	'HFG\Core\Components\FooterButton',
	'HFG\Core\Components\FooterButton2',
);

if ( class_exists( 'WooCommerce', false ) ) {
	$header_components[] = 'HFG\Core\Components\CartIcon';
	$footer_components[] = 'HFG\Core\Components\CartIconFooter';
}

add_theme_support(
	'hfg_support',
	array(
		'builders' => array(
			'HFG\Core\Builder\Header' => $header_components,
			'HFG\Core\Builder\Footer' => $footer_components
		),
	)
);
require_once 'functions-template.php';
require_once 'functions-migration.php';

add_action(
	'solace_do_footer',
	function () {
		do_action( 'hfg_footer_render' );
	}
);

add_action(
	'solace_do_header',
	function () {
		do_action( 'hfg_header_render' );
	}
);
if ( version_compare( PHP_VERSION, '5.3.29' ) > 0 && class_exists( 'HFG\Main' ) ) {
	add_action( 'after_setup_theme', 'HFG\Main::get_instance' );
}
