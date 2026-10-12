<?php
/**
 * Button Component class for Header Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Components;

use HFG\Core\Script_Register;
use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use Solace\Core\Dynamic_Css;
use HFG\Traits\Core;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Styles\Dynamic_Selector;
use Solace\Core\Theme_Info;
use Solace_Pro\Core\Settings;

/**
 * Class SearchResponsive
 *
 * @package HFG\Core\Components
 */
class CartIcon extends Abstract_Component {

	const COMPONENT_ID    = 'header_cart_icon';
	const SIZE_ID         = 'icon_size';
	const COLOR_ID        = 'color';
	const TOGGLE_ICON_ID    = 'toggle_icon';
	const TOGGLE_CUSTOM_ID  = 'toggle_icon_custom';
	const HOVER_COLOR_ID  = 'hover_color';
	const ICON_SELECTOR   = 'icon_selector';
	const ICON_CUSTOM     = 'icon_selector_custom';
	const CART_LABEL      = 'cart_label';
	const CART_FOCUS      = 'cart_focus';
	const MINI_CART_STYLE = 'mini_cart_style';
	const AFTER_CART_HTML = 'after_cart_html';
	const LABEL_SIZE_ID   = 'label_size';

	/**
	 * Margin settings default values.
	 *
	 * @var array
	 */
	protected $default_margin_value = array(
		'mobile'       => array(
			'top'    => 0,
			'right'  => 10,
			'bottom' => 0,
			'left'   => 10,
		),
		'tablet'       => array(
			'top'    => 0,
			'right'  => 10,
			'bottom' => 0,
			'left'   => 10,
		),
		'desktop'      => array(
			'top'    => 0,
			'right'  => 15,
			'bottom' => 0,
			'left'   => 15,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	/**
	 * Return a svg icon for the provided string.
	 *
	 * @param string $icon The icon string.
	 *
	 * @return string
	 */
	public static function get_icon( $icon, $icon_custom = '' ) {
		if ( $icon === 'custom' ) {
			return $icon_custom;
		}

		$available_icons = [
			'cart1' => '<svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M4.00598 13.997H12C12.2652 13.997 12.5196 14.1024 12.7071 14.2899C12.8946 14.4774 13 14.7318 13 14.997C13 15.2622 12.8946 15.5166 12.7071 15.7041C12.5196 15.8916 12.2652 15.997 12 15.997H3.00598C2.74076 15.997 2.48641 15.8916 2.29887 15.7041C2.11134 15.5166 2.00598 15.2622 2.00598 14.997V2.008H1.00598C0.740765 2.008 0.486411 1.90264 0.298875 1.7151C0.111338 1.52757 0.00598145 1.27321 0.00598145 1.008C0.00598145 0.742779 0.111338 0.488425 0.298875 0.300889C0.486411 0.113352 0.740765 0.00799561 1.00598 0.00799561H3.00598C3.2712 0.00799561 3.52555 0.113352 3.71309 0.300889C3.90062 0.488425 4.00598 0.742779 4.00598 1.008V3.008H13.926C14.1933 3.00323 14.459 3.05119 14.7078 3.14913C14.9565 3.24708 15.1836 3.3931 15.3759 3.57884C15.5683 3.76457 15.7221 3.98639 15.8287 4.23162C15.9352 4.47684 15.9924 4.74066 15.997 5.008C15.9966 5.15408 15.9799 5.29966 15.947 5.442L14.797 10.442C14.6863 10.8929 14.4262 11.2931 14.059 11.5773C13.6918 11.8615 13.2392 12.0129 12.775 12.007H4.00598V13.997ZM3.50598 19.997C3.20931 19.997 2.9193 19.909 2.67263 19.7442C2.42595 19.5794 2.23369 19.3451 2.12016 19.071C2.00663 18.7969 1.97693 18.4953 2.0348 18.2044C2.09268 17.9134 2.23554 17.6461 2.44532 17.4363C2.6551 17.2266 2.92237 17.0837 3.21335 17.0258C3.50432 16.9679 3.80592 16.9976 4.08001 17.1112C4.3541 17.2247 4.58836 17.417 4.75319 17.6636C4.91801 17.9103 5.00598 18.2003 5.00598 18.497C5.00466 18.894 4.84604 19.2742 4.56488 19.5544C4.28372 19.8346 3.90294 19.992 3.50598 19.992V19.997ZM12.499 19.997C12.2023 19.997 11.9123 19.909 11.6656 19.7442C11.419 19.5794 11.2267 19.3451 11.1132 19.071C10.9996 18.7969 10.9699 18.4953 11.0278 18.2044C11.0857 17.9134 11.2285 17.6461 11.4383 17.4363C11.6481 17.2266 11.9154 17.0837 12.2063 17.0258C12.4973 16.9679 12.7989 16.9976 13.073 17.1112C13.3471 17.2247 13.5814 17.417 13.7462 17.6636C13.911 17.9103 13.999 18.2003 13.999 18.497C13.9977 18.8945 13.8386 19.2752 13.5568 19.5555C13.275 19.8358 12.8935 19.9928 12.496 19.992L12.499 19.997ZM4.00598 5.008V10.008H12.83L13.998 5.008H4.00598Z" fill=""/>
			</svg>
			',
			'cart2' => '<svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M6.539 17.8959C6.53802 18.2849 6.42182 18.6649 6.20509 18.9879C5.98835 19.3109 5.68078 19.5625 5.3212 19.711C4.96162 19.8594 4.56613 19.8979 4.18465 19.8218C3.80317 19.7457 3.45279 19.5582 3.17772 19.2832C2.90265 19.0081 2.71522 18.6577 2.63909 18.2762C2.56296 17.8948 2.60153 17.4993 2.74994 17.1397C2.89834 16.7801 3.14994 16.4725 3.47297 16.2558C3.79601 16.0391 4.176 15.9229 4.565 15.9219C5.08805 15.9235 5.58923 16.1319 5.95908 16.5018C6.32894 16.8717 6.53742 17.3728 6.539 17.8959ZM14.439 15.9219C14.0486 15.9219 13.6669 16.0377 13.3423 16.2546C13.0177 16.4715 12.7647 16.7798 12.6153 17.1405C12.4659 17.5012 12.4268 17.8981 12.5029 18.281C12.5791 18.6639 12.7671 19.0156 13.0432 19.2917C13.3192 19.5678 13.671 19.7558 14.0539 19.832C14.4368 19.9081 14.8337 19.869 15.1944 19.7196C15.5551 19.5702 15.8634 19.3172 16.0803 18.9926C16.2972 18.668 16.413 18.2863 16.413 17.8959C16.4134 17.6362 16.3625 17.379 16.2632 17.1391C16.1639 16.8991 16.0181 16.6812 15.8343 16.4978C15.6505 16.3143 15.4323 16.169 15.1921 16.0702C14.952 15.9714 14.6947 15.921 14.435 15.9219H14.439ZM14.83 10.9869C15.2793 10.9872 15.7152 10.8342 16.0656 10.553C16.416 10.2719 16.66 9.87954 16.757 9.44088L18.388 3.09088H4.565V2.10388C4.565 1.84465 4.51395 1.58796 4.41474 1.34847C4.31554 1.10897 4.17014 0.891357 3.98683 0.708054C3.80353 0.524751 3.58592 0.379347 3.34642 0.280145C3.10693 0.180942 2.85023 0.129883 2.591 0.129883H0.617004V2.10388H2.591V12.9609C2.591 13.4844 2.79898 13.9865 3.16918 14.3567C3.53937 14.7269 4.04147 14.9349 4.565 14.9349H16.409C16.409 14.4113 16.201 13.9093 15.8308 13.5391C15.4606 13.1689 14.9585 12.9609 14.435 12.9609H4.565V10.9869H14.83Z" fill=""/>
			</svg>
			',
			'cart3' => '<svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M14.419 4.71538H11.668V3.79838C11.668 2.82544 11.2815 1.89234 10.5935 1.20436C9.90551 0.516384 8.97241 0.129883 7.99946 0.129883C7.02652 0.129883 6.09342 0.516384 5.40544 1.20436C4.71747 1.89234 4.33096 2.82544 4.33096 3.79838V4.71538H1.57996C1.33711 4.71538 1.10417 4.81172 0.932253 4.98326C0.760339 5.1548 0.663494 5.38753 0.662964 5.63038V15.7214C0.662964 16.451 0.952801 17.1507 1.46871 17.6666C1.98463 18.1825 2.68435 18.4724 3.41396 18.4724H12.585C12.9462 18.4724 13.304 18.4012 13.6377 18.263C13.9715 18.1247 14.2748 17.9221 14.5302 17.6666C14.7857 17.4112 14.9883 17.1079 15.1266 16.7741C15.2648 16.4404 15.336 16.0826 15.336 15.7214V5.63038C15.3354 5.38753 15.2386 5.1548 15.0667 4.98326C14.8948 4.81172 14.6618 4.71538 14.419 4.71538ZM6.16296 3.79838C6.16296 3.55754 6.2104 3.31905 6.30257 3.09654C6.39474 2.87403 6.52983 2.67185 6.70013 2.50155C6.87043 2.33125 7.07261 2.19615 7.29512 2.10399C7.51763 2.01182 7.75612 1.96438 7.99696 1.96438C8.23781 1.96438 8.47629 2.01182 8.6988 2.10399C8.92132 2.19615 9.12349 2.33125 9.2938 2.50155C9.4641 2.67185 9.59919 2.87403 9.69136 3.09654C9.78353 3.31905 9.83096 3.55754 9.83096 3.79838V4.71538H6.16296V3.79838ZM13.5 15.7204C13.5 15.8408 13.4762 15.96 13.4302 16.0713C13.3841 16.1826 13.3165 16.2836 13.2314 16.3688C13.1462 16.454 13.0451 16.5215 12.9339 16.5676C12.8226 16.6137 12.7034 16.6374 12.583 16.6374H3.41396C3.29354 16.6374 3.1743 16.6137 3.06304 16.5676C2.95179 16.5215 2.8507 16.454 2.76555 16.3688C2.6804 16.2836 2.61285 16.1826 2.56677 16.0713C2.52068 15.96 2.49696 15.8408 2.49696 15.7204V6.55038H4.33096V7.46738C4.33096 7.5878 4.35468 7.70705 4.40077 7.8183C4.44685 7.92956 4.5144 8.03065 4.59955 8.1158C4.6847 8.20095 4.78579 8.2685 4.89704 8.31458C5.0083 8.36066 5.12754 8.38438 5.24796 8.38438C5.36839 8.38438 5.48763 8.36066 5.59888 8.31458C5.71014 8.2685 5.81123 8.20095 5.89638 8.1158C5.98153 8.03065 6.04908 7.92956 6.09516 7.8183C6.14125 7.70705 6.16496 7.5878 6.16496 7.46738V6.55038H9.83296V7.46738C9.83296 7.71059 9.92958 7.94383 10.1015 8.1158C10.2735 8.28777 10.5068 8.38438 10.75 8.38438C10.9932 8.38438 11.2264 8.28777 11.3984 8.1158C11.5704 7.94383 11.667 7.71059 11.667 7.46738V6.55038H13.501L13.5 15.7204Z" fill=""/>
			</svg>
			',
			'cart4' => '<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M18.5248 7.92084C18.7607 7.92115 18.9911 7.99131 19.1872 8.12246C19.3832 8.25362 19.536 8.4399 19.6263 8.6578C19.7166 8.8757 19.7403 9.11546 19.6945 9.34682C19.6486 9.57819 19.5353 9.7908 19.3688 9.95784C19.2595 10.0707 19.1282 10.1601 18.983 10.2203C18.8379 10.2805 18.6819 10.3103 18.5248 10.3078H18.3848L17.3168 16.4828C17.2675 16.7591 17.1229 17.0092 16.9082 17.1899C16.6936 17.3706 16.4224 17.4704 16.1418 17.4718H4.19879C3.91821 17.4704 3.64701 17.3706 3.43235 17.1899C3.21768 17.0092 3.07312 16.7591 3.02379 16.4828L1.95079 10.3088H1.81079C1.65358 10.3111 1.49758 10.2812 1.35241 10.2208C1.20725 10.1604 1.076 10.0709 0.966787 9.95784C0.85588 9.84704 0.767898 9.71547 0.707869 9.57065C0.647841 9.42584 0.616943 9.27061 0.616943 9.11384C0.616943 8.95707 0.647841 8.80184 0.707869 8.65702C0.767898 8.5122 0.85588 8.38063 0.966787 8.26984C1.07613 8.15698 1.20742 8.0677 1.35257 8.0075C1.49772 7.94731 1.65366 7.91747 1.81079 7.91984L18.5248 7.92084ZM5.13979 15.3828C5.29738 15.3683 5.44311 15.2929 5.54599 15.1727C5.64888 15.0524 5.70082 14.8968 5.69079 14.7388L5.39079 10.8588C5.38019 10.7417 5.33542 10.6303 5.26205 10.5385C5.18867 10.4466 5.08992 10.3783 4.97807 10.3421C4.86621 10.3059 4.74618 10.3033 4.63288 10.3347C4.51958 10.3662 4.41801 10.4302 4.34079 10.5188C4.28836 10.5773 4.24851 10.6459 4.22374 10.7204C4.19896 10.7949 4.18979 10.8736 4.19679 10.9518L4.49679 14.8318C4.50936 14.9821 4.57808 15.1222 4.68927 15.2241C4.80045 15.3261 4.94595 15.3824 5.09679 15.3818H5.14379L5.13979 15.3828ZM8.97379 14.7828V10.9028C8.95893 10.7548 8.88962 10.6176 8.77931 10.5178C8.66899 10.418 8.52554 10.3628 8.37679 10.3628C8.22803 10.3628 8.08458 10.418 7.97427 10.5178C7.86395 10.6176 7.79464 10.7548 7.77979 10.9028V14.7828C7.79464 14.9308 7.86395 15.0681 7.97427 15.1679C8.08458 15.2677 8.22803 15.3229 8.37679 15.3229C8.52554 15.3229 8.66899 15.2677 8.77931 15.1679C8.88962 15.0681 8.95893 14.9308 8.97379 14.7828ZM12.5558 14.7828V10.9028C12.5409 10.7548 12.4716 10.6176 12.3613 10.5178C12.251 10.418 12.1075 10.3628 11.9588 10.3628C11.81 10.3628 11.6666 10.418 11.5563 10.5178C11.446 10.6176 11.3766 10.7548 11.3618 10.9028V14.7828C11.3766 14.9308 11.446 15.0681 11.5563 15.1679C11.6666 15.2677 11.81 15.3229 11.9588 15.3229C12.1075 15.3229 12.251 15.2677 12.3613 15.1679C12.4716 15.0681 12.5409 14.9308 12.5558 14.7828ZM15.8388 14.8298L16.1388 10.9498C16.141 10.7973 16.0851 10.6496 15.9823 10.5368C15.8795 10.424 15.7376 10.3547 15.5854 10.3428C15.4333 10.331 15.2824 10.3775 15.1634 10.473C15.0444 10.5685 14.9662 10.7058 14.9448 10.8568L14.6448 14.7368C14.6345 14.8947 14.6862 15.0503 14.7889 15.1706C14.8916 15.2909 15.0373 15.3663 15.1948 15.3808H15.2418C15.3926 15.3826 15.5382 15.3255 15.6478 15.2218C15.7605 15.1214 15.8292 14.9805 15.8388 14.8298ZM5.05679 3.48184L4.18879 7.32384H2.95779L3.89979 3.21084C4.00788 2.68006 4.30228 2.20547 4.72979 1.87284C5.15243 1.53349 5.67981 1.35145 6.22179 1.35784H7.77979C7.77864 1.27895 7.79376 1.20068 7.82421 1.1279C7.85467 1.05512 7.8998 0.989396 7.95679 0.934838C8.011 0.87822 8.07623 0.833306 8.14847 0.802865C8.2207 0.772423 8.2984 0.7571 8.37679 0.757838H11.9588C12.0372 0.7571 12.1149 0.772423 12.1871 0.802865C12.2593 0.833306 12.3246 0.87822 12.3788 0.934838C12.4354 0.98905 12.4803 1.05428 12.5108 1.12652C12.5412 1.19875 12.5565 1.27645 12.5558 1.35484H14.1168C14.6595 1.3489 15.1874 1.53204 15.6098 1.87284C16.0374 2.20535 16.3319 2.68 16.4398 3.21084L17.3818 7.32384H16.1468L15.2788 3.48084C15.2161 3.21592 15.0669 2.97945 14.8548 2.80884C14.6465 2.63679 14.3839 2.54429 14.1138 2.54784H12.5548C12.5555 2.62622 12.5402 2.70392 12.5098 2.77616C12.4793 2.84839 12.4344 2.91363 12.3778 2.96784C12.3236 3.02446 12.2583 3.06937 12.1861 3.09981C12.1139 3.13025 12.0362 3.14558 11.9578 3.14484H8.37679C8.2984 3.14558 8.2207 3.13025 8.14847 3.09981C8.07623 3.06937 8.011 3.02446 7.95679 2.96784C7.90017 2.91363 7.85526 2.84839 7.82481 2.77616C7.79437 2.70392 7.77905 2.62622 7.77979 2.54784H6.22179C5.95169 2.54447 5.68915 2.63694 5.48079 2.80884C5.26859 2.97981 5.1194 3.21662 5.05679 3.48184Z" fill=""/>
			</svg>
			',
			'cart5' => '<svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M14.466 0.129883L17.773 5.85688H21.297V7.91588H20.097L19.316 17.2729C19.2947 17.5304 19.1773 17.7705 18.9873 17.9455C18.7972 18.1205 18.5484 18.2178 18.29 18.2179H3.71098C3.4526 18.2178 3.20371 18.1205 3.01367 17.9455C2.82362 17.7705 2.7063 17.5304 2.68498 17.2729L1.90398 7.91588H0.703979V5.85688H4.22698L7.53498 0.129883L9.31798 1.15988L6.60398 5.85688H15.394L12.683 1.15688L14.466 0.129883ZM18.029 7.91588H3.97098L4.65798 16.1529H17.343L18.029 7.91588ZM12.029 9.97488V14.0939H9.97098V9.97288L12.029 9.97488ZM7.90998 9.97488V14.0939H5.85198V9.97288L7.90998 9.97488ZM16.147 9.97488V14.0939H14.089V9.97288L16.147 9.97488Z" fill=""/>
			</svg>
			',
		];

		if ( in_array( $icon, array_keys( $available_icons ), true ) ) {
			return $available_icons[ $icon ];
		}

		return $available_icons['cart1'];
	}

	/**
	 * Button constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Cart', 'solace' ) );
		$this->set_property( 'id', self::COMPONENT_ID );
		$this->set_property( 'width', 1 );
		$this->set_property( 'icon', 'store' );
		$this->set_property( 'default_selector', '.builder-item--' . $this->get_id() );
		$this->set_property( 'is_auto_width', true );

		if ( function_exists( 'do_blocks' ) ) {
			add_filter( 'solace_post_content', 'do_blocks' );
		}
		add_filter( 'solace_post_content', 'wptexturize' );
		add_filter( 'solace_post_content', 'convert_smilies' );
		add_filter( 'solace_post_content', 'convert_chars' );
		add_filter( 'solace_post_content', 'wpautop' );
		add_filter( 'solace_post_content', 'shortcode_unautop' );
		add_filter( 'solace_post_content', 'do_shortcode' );

		add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
	}

	/**
	 * Load Component Scripts
	 *
	 * @return void
	 */
	public function load_scripts() {
		if ( $this->is_component_active() ) {
			wp_add_inline_script( 'solace-script', $this->toggle_cart_is_empty() );
		}
		if ( $this->is_component_active() || is_customize_preview() ) {
			wp_add_inline_style( 'solace-style', $this->toggle_style() );
		}
	}

	/**
	 * Get CSS to use as inline script
	 *
	 * @return string
	 */
	public function toggle_style() {
		$css = '.toggle-palette a {
			display: flex;
			align-items: center;
		}
		.sol_cart_icon svg {
			width: var(--iconsize);
			height: var(--iconsize);
			fill: var(--color);
		}
		.toggle-palette .label {
			font-size: 0.85em;
			margin-left: 5px;
		}';

		return Dynamic_Css::minify_css( $css );
	}

	/**
	 * Inline script that removes the cart-is-empty class.
	 *
	 * @return string
	 */
	public function toggle_cart_is_empty() {
		return '
			(function($){
				$(\'body\').on( \'added_to_cart\', function(){
					var responsiveCart = document.querySelector( \'.responsive-nav-cart\' );
					if ( responsiveCart ) {
						responsiveCart.classList.remove(\'cart-is-empty\');
					}
				});
			})(jQuery);
		';
	}

	/**
	 * Method to filter component loading if needed.
	 *
	 * @return bool
	 * @since   1.0.1
	 * @access  public
	 */
	public function is_active() {
		return class_exists( 'WooCommerce', false );
	}

	/**
	 * Define settings for this component.
	 */
	public function add_settings() {

		do_action( 'nv_cart_icon_component_controls' );

		$custom_icon_args = $this->should_load_pro_features() ? [
			'settings'       => [
				'default' => self::COMPONENT_ID . '_' . self::TOGGLE_ICON_ID,
				'custom'  => self::COMPONENT_ID . '_' . self::TOGGLE_CUSTOM_ID,
			],
			'setting_custom' => [
				'transport'         => 'post' . self::COMPONENT_ID,
				'sanitize_callback' => 'solace_kses_svg',
				'default'           => '',
			],
		] : [];

		SettingsManager::get_instance()->add(
			array_merge(
			[
				'id'                => self::TOGGLE_ICON_ID,
				'group'             => $this->get_id(),
				'tab'               => SettingsManager::TAB_GENERAL,
				'transport'         => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback' => 'wp_filter_nohtml_kses',
				'type'              => 'Solace\Customizer\Controls\React\Radio_Buttons',
				'default'           => 'cart1',
				'options'           => [
					'is_for' => 'sol_cart',
				],
				'section'           => $this->section,
			],
			$custom_icon_args
			)
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::COLOR_ID,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Icon Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					[
						'selector' => $this->default_selector . ' svg',
						'prop'     => 'fill',
						'fallback' => 'inherit',
					],
					[
						'selector' => $this->default_selector . ' .cart-icon-label',
						'prop'     => 'color',
						'fallback' => 'inherit',
					],
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::SIZE_ID,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'absint',
				'default'               => 15,
				'label'                 => __( 'Icon Size', 'solace' ),
				'type'                  => 'Solace\Customizer\Controls\React\Range',
				'options'               => [
					'input_attrs' => [
						'min'        => 10,
						'max'        => 100,
						'defaultVal' => 15,
					],
				],
				// 'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--iconsize',
						'suffix'   => 'px',
						'selector' => '.builder-item--' . $this->get_id() .' svg',
					],
					// 'cssVar'   => [
					// 	'vars'     => 'height',
					// 	'suffix'   => 'px',
					// 	'selector' => '.builder-item--' . $this->get_id() .' svg',
					// ],
					'template' =>
						'body ' . $this->default_selector . ' .sol_cart_icon  svg {
							width: {{value}}px;
							height: {{value}}px;
						}',
				],
				// 'live_refresh_selector' => $this->default_selector . ' span.nv-icon.nv-cart svg',
				'live_refresh_selector' => $this->default_selector . ' svg',
				// 'live_refresh_css_prop' => [
				// 	'cssVar'  => [
				// 		// 'vars'     => '--iconsize',
				// 		// 'selector' => '.builder-item--' . $this->get_id() .' svg',
				// 		// 'suffix'   => 'px',
				// 		'vars'		=> 'width',
				// 		'selector' 	=> '.builder-item--' . $this->get_id() .' svg',
				// 		'suffix'   	=> 'px',
				// 	],
				// 	[
				// 		'selector' 	=> '.builder-item--' . $this->get_id() .' svg',
				// 		'vars'     => 'height',
				// 		'fallback' => 'auto',
				// 	],
				// 	// [
				// 	// 	'vars'		=> 'height',
				// 	// 	'selector' 	=> '.builder-item--' . $this->get_id() .' svg',
				// 	// 	'suffix'   	=> 'px',
				// 	// ],
				// 	'type'    => 'svg-icon-size',
				// 	'default' => 15,
				// ],
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);

		

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::HOVER_COLOR_ID,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Hover Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--hovercolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					[
						'selector' => $this->default_selector . ':hover svg',
						'prop'     => 'fill',
						'fallback' => 'inherit',
					],
					[
						'selector' => $this->default_selector . ':hover .cart-icon-label',
						'prop'     => 'color',
						'fallback' => 'inherit',
					],
				],
			]
		);
	}

	/**
	 * Add legacy style.
	 *
	 * @param array $css_array css array.
	 *
	 * @return array
	 */
	private function add_legacy_style( $css_array ) {
		$selector = '.builder-item--' . $this->get_id() . ' .sol_cart_icon svg';

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector,
			// Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' span.sol_cart_icon svg',
			// Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' svg',
			Dynamic_Selector::KEY_RULES    => [
				\Solace\Core\Settings\Config::CSS_PROP_WIDTH => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SIZE_ID ),
				],
				\Solace\Core\Settings\Config::CSS_PROP_HEIGHT => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SIZE_ID ),
				],
				\Solace\Core\Settings\Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .cart-icon-label',
			Dynamic_Selector::KEY_RULES    => [
				\Solace\Core\Settings\Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ':hover span.nv-icon.nv-cart svg',
			Dynamic_Selector::KEY_RULES    => [
				\Solace\Core\Settings\Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ':hover .cart-icon-label',
			Dynamic_Selector::KEY_RULES    => [
				\Solace\Core\Settings\Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];


		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .cart-icon-label',
			Dynamic_Selector::KEY_RULES    => [
				\Solace\Core\Settings\Config::CSS_PROP_FONT_SIZE => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::LABEL_SIZE_ID,
					Dynamic_Selector::META_SUFFIX  => 'px',
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::LABEL_SIZE_ID ),
				],
			],
		];

		return parent::add_style( $css_array );
	}

	/**
	 * Method to add Component css styles.
	 *
	 * @param array $css_array An array containing css rules.
	 *
	 * @return array
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_style( array $css_array = array() ) {
		if ( ! solace_is_new_skin() ) {
			return $this->add_legacy_style( $css_array );
		}

		$rules = [
			'--iconsize'   => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SIZE_ID ),
			],
			'--labelsize'  => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::LABEL_SIZE_ID,
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_DEFAULT => 15,
			],
			'--color'      => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
			],
			'--hovercolor' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector,
		];

		return parent::add_style( $css_array );
	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		Main::get_instance()->load( 'components/component-cart-icon' );
	}

	/**
	 * Check if pro features should load.
	 *
	 * @return bool
	 */
	public static function should_load_pro_features() {
		if ( ! class_exists( '\Solace_Pro\Modules\Woocommerce_Booster\Customizer\Cart_Icon' ) ) {
			return false;
		}

		if ( ! apply_filters( 'nv_pro_woocommerce_booster_status', false ) || ! class_exists( 'WooCommerce' ) ) {
			return false;
		}

		return true;
	}
}
