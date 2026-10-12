<?php
/**
 * Navid Customizer Notify Section
 *
 * @package Navid
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Navid Customizer Notify Section Class
 */
if (class_exists('WP_Customize_Section')) {

    class Navid_Customizer_Notify_Section extends WP_Customize_Section {

        /**
         * The type of customize section being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'navid-notify-section';

        /**
         * Custom button text to output.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_text = '';

        /**
         * Custom pro button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $pro_url = '';

        /**
         * Custom demo button text.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $demo_text = '';

        /**
         * Custom demo button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $demo_url = '';

        /**
         * Custom help button text.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $help_text = '';

        /**
         * Custom help button URL.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $help_url = '';

        /**
         * Add custom parameters to pass to the JS via JSON.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function json() {
            $json = parent::json();

            $json['pro_text'] = $this->pro_text;
            $json['pro_url']  = esc_url($this->pro_url);
            $json['demo_text'] = $this->demo_text;
            $json['demo_url']  = esc_url($this->demo_url);
            $json['help_text'] = $this->help_text;
            $json['help_url']  = esc_url($this->help_url);

            return $json;
        }

        /**
         * Outputs the Underscore.js template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        protected function render_template() { ?>
            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
                <h3 class="accordion-section-title">
                    <span class="navid-customizer-notify-section-title">
                        {{ data.title }}
                    </span>
                    <div class="navid-customizer-notify-buttons">
                        <# if ( data.demo_text && data.demo_url ) { #>
                            <a href="{{ data.demo_url }}" class=" navid-customizer-notify-demo-btn" target="_blank">{{ data.demo_text }}</a>
                        <# } #>
                        <# if ( data.pro_text && data.pro_url ) { #>
                            <a href="{{ data.pro_url }}" class=" navid-customizer-notify-pro-btn" target="_blank">{{ data.pro_text }}</a>
                        <# } #>
                        <# if ( data.help_text && data.help_url ) { #>
                            <a href="{{ data.help_url }}" class=" navid-customizer-notify-help-btn" target="_blank">{{ data.help_text }}</a>
                        <# } #>
                    </div>
                </h3>
            </li>
        <?php }
    }
}
?>
