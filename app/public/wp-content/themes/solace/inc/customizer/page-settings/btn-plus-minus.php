<?php

if (class_exists('WP_Customize_Control')) {
    class Solace_Custom_Button_Plus_Minus extends WP_Customize_Control
    {

        public $type = 'button_plus_minus';

        public function __construct($manager, $id, $args = array())
        {

            parent::__construct($manager, $id, $args);

            $defaults = array(
                'min'  => 1,
                'max'  => 20
            );

            $args = wp_parse_args($args, $defaults);

            $this->min  = $args['min'];
            $this->max  = $args['max'];
        }

        public function render_content()
        {
?>
            <div id="<?php echo esc_attr($this->id); ?>" class="container-btn-plus-minus">
                <label class="title-customize"><?php echo esc_html($this->label); ?></label>
                <div class="qty">
                    <span class="minus">-</span>
                    <input type="number" min="<?php echo esc_attr($this->min); ?>" max="<?php echo esc_attr($this->max); ?>" id="<?php echo esc_attr($this->id); ?>" class="count" <?php $this->link(); ?>name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>">
                    <span class="plus">+</span>
                </div>
            </div>
<?php
        } // End Function render_content()
    } // End Class Solace_Custom_Button_Plus_Minus
} // End Check class_exists