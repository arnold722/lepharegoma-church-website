<?php

/**
 * HeaderSocial Control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class HeaderSocial
 *
 * @package Solace\Customizer\Controls\React
 */
class HeaderSocial extends \WP_Customize_Control
{
    /**
     * Control type.
     *
     * @var string
     */
    public $type = 'solace_header_social_control';

    /**
     * Additional arguments passed to JS.
     * Disables hover controls
     *
     * @var bool
     */
    public $no_hover = false;
    /**
     * Additional arguments passed to JS.
     * Disables shadow controls
     *
     * @var bool
     */
    public $no_shadow = false;
    /**
     * Default values.
     *
     * @var array
     */
    public $default_vals = [];

    /**
     * Send to JS.
     */
    public function json()
    {
        $json                = parent::json();
        $json['no_hover']    = $this->no_hover;
        $json['no_shadow']   = $this->no_shadow;
        $json['defaultVals'] = $this->default_vals;
        return $json;
    }

    /**
     * Button labels
     */
    public $button_labels = array();
    /**
     * Constructor
     */
    public function __construct($manager, $id, $args = array(), $options = array())
    {
        parent::__construct($manager, $id, $args);
        // Merge the passed button labels with our default labels
        $this->button_labels = wp_parse_args(
            $this->button_labels,
            array(
                'add' => __('Add', 'solace'),
            )
        );
    }
    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {

        wp_enqueue_script('solace-custom-js-header-social', get_template_directory_uri() . '/assets-solace/customizer/js/header-social.js?v=' . time(), array('jquery', 'jquery-ui-core'), '1.0', true);

        wp_enqueue_style('solace-custom-css-header-social', get_template_directory_uri() . '/assets-solace/customizer/css/header-social.css?v=' . time(), array(), '1.0', 'all');
    }

    /**
     * Render the control in the customizer
     */
    final public function render_content()
    {
?>
        <div class="header_social_sortable_control">
            <?php if (!empty($this->label)) { ?>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
            <?php } ?>
            <?php if (!empty($this->description)) { ?>
                <span class="customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php } ?>
            <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this->value()); ?>" class="getDataHidden" <?php $this->link(); ?> />
            <div class="sortable_repeater_header_social sortable">
                <?php
                $social = trim(esc_attr($this->value()));
                $data = explode(",", $social);
                $sosmed = count($data) / 4 + count($data) / 4 + count($data) / 4;
                if (count($data) > 1) :
                ?>
                    <div class="repeater <?php echo esc_attr($data[0]); ?>">
                        <div class="box-info">
                            <div class="drag">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                    <path d="M56 472a56 56 0 1 1 0-112 56 56 0 1 1 0 112zm0-160a56 56 0 1 1 0-112 56 56 0 1 1 0 112zM0 96a56 56 0 1 1 112 0A56 56 0 1 1 0 96z"></path>
                                </svg>
                            </div>
                            <?php if ( 'twitter' === $data[$sosmed] ) : ?>
                                <div class="text-code">
                                    <?php echo esc_html('X (Twitter)'); ?>
                                </div>
                            <?php endif; ?>                            
                            <div class="text">
                                <?php echo esc_html($data[$sosmed]); ?>
                            </div>
                            <div class="box-color-custom">
                                <button type="button">
                                    <span class="color"></span>
                                    <span class="gradient"></span>
                                </button>
                            </div>
                            <div class="box-color-ori">
                                <button type="button">
                                    <span class="color"></span>
                                    <span class="gradient"></span>
                                </button>
                            </div>
                            <div id="toggle-slide" class="toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
                            </div>
                            <div class="close">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z" />
                                </svg>
                            </div>
                        </div>
                        <div class="box-input-title">
                            <label>
                                <?php esc_html_e('Title', 'solace'); ?>
                                <input type="text" value="" class="title" placeholder="" />
                            </label>
                        </div>
                        <div class="box-input-content" style="display: none;">
                            <label>
                                <?php esc_html_e('Content', 'solace'); ?>
                                <input type="text" value="" class="content" placeholder="" />
                            </label>
                        </div>
                        <div class="box-input-link">
                            <label>
                                <?php esc_html_e('Link', 'solace'); ?>
                                <input type="text" value="" class="link" placeholder="<?php echo esc_html('Link ' . $data[$sosmed]);  ?>" />
                            </label>
                        </div>
                        <div class="box-input-sosmed">
                            <label>
                                <?php esc_html_e('Sosmed', 'solace'); ?>
                                <input type="text" value="" class="sosmed" placeholder="" />
                            </label>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <button style="display:none;" class="button control-sortable-repeater-header-social-add" type="button"><?php echo $this->button_labels['add']; ?></button>

            <span class="add-new-label"><?php esc_html_e('Add new', 'solace') ?></span>

            <?php $socials = array('facebook', 'youtube', 'twitter', 'tiktok', 'telegram', 'pinterest', 'linkedin', 'instagram', 'threads', 'whatsapp' ); ?>
            <div class="container-dropdown-header-social">
                <div id="box-dropdown" class="box-dropdown">
                    <span class="title-active"><?php echo esc_html($socials[0]); ?></span>
                    <p class="arrow-top">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path></svg>
                    </p>
                    <ul>
                        <?php foreach ($socials as $value) : ?>
                            <li id="<?php echo esc_attr($value); ?>" status="show" data="<?php echo esc_attr($value); ?>"><?php echo esc_html( $value === 'twitter' ? 'x (twitter)' : $value ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="box-add-dropdown">
                    <button type="button">
                        <?php //esc_html_e('Add', 'solace'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
    }
}
