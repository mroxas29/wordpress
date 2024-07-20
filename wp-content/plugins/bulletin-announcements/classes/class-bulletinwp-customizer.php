<?php

defined( 'ABSPATH' ) or exit;
class BULLETINWP_Customizer {
    public function __construct() {
        add_action( 'customize_controls_enqueue_scripts', array($this, 'enqueue_customizer_controls_assets') );
        add_action( 'customize_preview_init', array($this, 'enqueue_customizer_preview_assets') );
        add_action( 'customize_register', array($this, 'setup_customizer_panel'), 10 );
        add_action( 'wp_ajax_bulletinwp_get_bulletin_data', array($this, 'get_bulletin_data') );
        add_action( 'customize_save_after', array($this, 'save_bulletin_data') );
    }

    /**
     * Enqueue customizer controls assets
     *
     * @param void
     *
     * @return void
     * @since 2.0.0
     *
     */
    public function enqueue_customizer_controls_assets() {
        $plugin_slug = BULLETINWP_PLUGIN_SLUG;
        wp_enqueue_script(
            "{$plugin_slug}-customizer-controls-scripts",
            plugin_dir_url( BULLETINWP__FILE__ ) . 'customizer/build/controls.js',
            array('jquery', 'customize-controls'),
            BULLETINWP_PLUGIN_VERSION,
            true
        );
        wp_localize_script( "{$plugin_slug}-customizer-controls-scripts", 'BULLETINWP_CUSTOMIZER_CONTROLS', [
            'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
            'pluginSlug' => $plugin_slug,
            'isPremium'  => bulletinwp_fs()->is__premium_only(),
        ] );
    }

    /**
     * Enqueue customizer preview assets
     *
     * @param void
     *
     * @return void
     * @since 2.0.0
     *
     */
    public function enqueue_customizer_preview_assets() {
        $plugin_slug = BULLETINWP_PLUGIN_SLUG;
        wp_enqueue_script(
            "{$plugin_slug}-customizer-preview-scripts",
            plugin_dir_url( BULLETINWP__FILE__ ) . 'customizer/build/preview.js',
            array('jquery', 'customize-preview'),
            BULLETINWP_PLUGIN_VERSION,
            true
        );
        wp_localize_script( "{$plugin_slug}-customizer-preview-scripts", 'BULLETINWP_CUSTOMIZER_PREVIEW', [
            'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
            'pluginSlug' => $plugin_slug,
            'isPremium'  => bulletinwp_fs()->is__premium_only(),
        ] );
    }

    /**
     * Setup customizer panel
     *
     * @param object $wp_customize
     *
     * @return void
     * @since 2.0.0
     *
     */
    public function setup_customizer_panel( $wp_customize ) {
        $plugin_slug = BULLETINWP_PLUGIN_SLUG;
        $bulletins = BULLETINWP::instance()->sql->get_all_active_bulletins();
        $bulletin_choices = [
            '' => __( 'Please select', 'bulletinwp' ),
        ];
        $defaults = [
            'id'                => '',
            'content'           => '',
            'mobile_content'    => '',
            'background_color'  => '',
            'font_color'        => '',
            'placement'         => 'top',
            'content_max_width' => '',
            'text_alignment'    => 'center',
            'font_size'         => '',
            'font_size_mobile'  => '',
        ];
        $placement_control_choices = [
            'top'           => __( 'Header banner', 'bulletinwp' ),
            'float-bottom'  => __( 'Floating at bottom', 'bulletinwp' ),
            'sticky-footer' => __( 'Sticky footer', 'bulletinwp' ),
        ];
        if ( !empty( $bulletins ) ) {
            foreach ( $bulletins as $key => $bulletin ) {
                $bulletin_choices[$bulletin['id']] = $bulletin['bulletin_title'];
            }
        }
        $wp_customize->add_section( "{$plugin_slug}-customizer-panel-general-section", [
            'title'    => BULLETINWP_PLUGIN_NAME,
            'priority' => 10,
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-bulletin-id", [
            'default'   => $defaults['id'],
            'transport' => 'refresh',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-content", [
            'default'   => $defaults['content'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-mobile-content", [
            'default'   => $defaults['mobile_content'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-background-color", [
            'default'   => $defaults['background_color'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-font-color", [
            'default'   => $defaults['font_color'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-placement", [
            'default'   => $defaults['placement'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-content-max-width", [
            'default'   => $defaults['content_max_width'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-text-alignment", [
            'default'   => $defaults['text_alignment'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-font-size", [
            'default'   => $defaults['font_size'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_setting( "{$plugin_slug}-general-section-font-size-mobile", [
            'default'   => $defaults['font_size_mobile'],
            'transport' => 'postMessage',
        ] );
        $wp_customize->add_control( "{$plugin_slug}-bulletin-id-control", [
            'label'    => __( 'Bulletin', 'bulletinwp' ),
            'section'  => "{$plugin_slug}-customizer-panel-general-section",
            'settings' => "{$plugin_slug}-general-section-bulletin-id",
            'type'     => 'select',
            'choices'  => $bulletin_choices,
        ] );
        $wp_customize->add_control( "{$plugin_slug}-content-control", [
            'label'       => __( 'Message', 'bulletinwp' ),
            'description' => __( 'Tablet and up', 'bulletinwp' ),
            'section'     => "{$plugin_slug}-customizer-panel-general-section",
            'settings'    => "{$plugin_slug}-general-section-content",
            'type'        => 'textarea',
        ] );
        $wp_customize->add_control( "{$plugin_slug}-mobile-content-control", [
            'description' => __( 'Mobile only', 'bulletinwp' ),
            'section'     => "{$plugin_slug}-customizer-panel-general-section",
            'settings'    => "{$plugin_slug}-general-section-mobile-content",
            'type'        => 'textarea',
        ] );
        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, "{$plugin_slug}-background-color-control", [
            'label'       => __( 'Colors', 'bulletinwp' ),
            'description' => __( 'Background color', 'bulletinwp' ),
            'section'     => "{$plugin_slug}-customizer-panel-general-section",
            'settings'    => "{$plugin_slug}-general-section-background-color",
        ]) );
        $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, "{$plugin_slug}-font-color-control", [
            'description' => __( 'Font color', 'bulletinwp' ),
            'section'     => "{$plugin_slug}-customizer-panel-general-section",
            'settings'    => "{$plugin_slug}-general-section-font-color",
        ]) );
        $wp_customize->add_control( "{$plugin_slug}-placement-control", [
            'label'    => __( 'Display type', 'bulletinwp' ),
            'section'  => "{$plugin_slug}-customizer-panel-general-section",
            'settings' => "{$plugin_slug}-general-section-placement",
            'type'     => 'radio',
            'choices'  => $placement_control_choices,
        ] );
        $wp_customize->add_control( "{$plugin_slug}-content-max-width-control", [
            'label'    => __( 'Content max-width (in px, leave blank for 100% width)', 'bulletinwp' ),
            'section'  => "{$plugin_slug}-customizer-panel-general-section",
            'settings' => "{$plugin_slug}-general-section-content-max-width",
            'type'     => 'number',
        ] );
        $wp_customize->add_control( "{$plugin_slug}-text-alignment-control", [
            'label'    => __( 'Text alignment', 'bulletinwp' ),
            'section'  => "{$plugin_slug}-customizer-panel-general-section",
            'settings' => "{$plugin_slug}-general-section-text-alignment",
            'type'     => 'radio',
            'choices'  => [
                'center' => __( 'Center', 'bulletinwp' ),
                'left'   => __( 'Left', 'bulletinwp' ),
                'right'  => __( 'Right', 'bulletinwp' ),
            ],
        ] );
        $wp_customize->add_control( "{$plugin_slug}-font-size-control", [
            'label'       => __( 'Font Size (in px, leave blank for default font-size)', 'bulletinwp' ),
            'description' => __( 'Desktop', 'bulletinwp' ),
            'section'     => "{$plugin_slug}-customizer-panel-general-section",
            'settings'    => "{$plugin_slug}-general-section-font-size",
            'type'        => 'number',
        ] );
        $wp_customize->add_control( "{$plugin_slug}-font-size-mobile-control", [
            'description' => __( 'Mobile', 'bulletinwp' ),
            'section'     => "{$plugin_slug}-customizer-panel-general-section",
            'settings'    => "{$plugin_slug}-general-section-font-size-mobile",
            'type'        => 'number',
        ] );
    }

    /**
     * Get bulletin data
     *
     * @param void
     *
     * @return void
     * @since 2.0.0
     *
     */
    public function get_bulletin_data() {
        $plugin_slug = BULLETINWP_PLUGIN_SLUG;
        $bulletin_id = sanitize_text_field( $_POST['bulletinID'] );
        $data = [];
        if ( !empty( $bulletin_id ) ) {
            $content = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'content' );
            $mobile_content = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'mobile_content' );
            $background_color = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'background_color' );
            $font_color = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'font_color' );
            $placement = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'placement' );
            $content_max_width = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'content_max_width' );
            $text_alignment = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'text_alignment' );
            $font_size = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'font_size' );
            $font_size_mobile = BULLETINWP::instance()->sql->get_bulletin_data( $bulletin_id, 'font_size_mobile' );
            $data = [
                'content'           => $content,
                'mobile_content'    => $mobile_content,
                'background_color'  => $background_color,
                'font_color'        => $font_color,
                'placement'         => $placement,
                'content_max_width' => $content_max_width,
                'text_alignment'    => $text_alignment,
                'font_size'         => $font_size,
                'font_size_mobile'  => $font_size_mobile,
            ];
        }
        wp_send_json_success( [
            'data' => $data,
        ] );
    }

    /**
     * Save bulletin data
     *
     * @param void
     *
     * @return void
     * @since 2.0.0
     *
     */
    public function save_bulletin_data() {
        $plugin_slug = BULLETINWP_PLUGIN_SLUG;
        $bulletin_id = get_theme_mod( "{$plugin_slug}-general-section-bulletin-id" );
        if ( !empty( $bulletin_id ) ) {
            $args = [
                'id'   => $bulletin_id,
                'data' => [
                    'content'           => get_theme_mod( "{$plugin_slug}-general-section-content" ),
                    'mobile_content'    => get_theme_mod( "{$plugin_slug}-general-section-mobile-content" ),
                    'background_color'  => get_theme_mod( "{$plugin_slug}-general-section-background-color" ),
                    'font_color'        => get_theme_mod( "{$plugin_slug}-general-section-font-color" ),
                    'placement'         => get_theme_mod( "{$plugin_slug}-general-section-placement" ),
                    'content_max_width' => get_theme_mod( "{$plugin_slug}-general-section-content-max-width" ),
                    'text_alignment'    => get_theme_mod( "{$plugin_slug}-general-section-text-alignment" ),
                    'font_size'         => get_theme_mod( "{$plugin_slug}-general-section-font-size" ),
                    'font_size_mobile'  => get_theme_mod( "{$plugin_slug}-general-section-font-size-mobile" ),
                ],
            ];
            BULLETINWP::instance()->sql->update_bulletin( $args );
        }
    }

    /**
     * Reset values
     *
     * @param string $bulletin_id
     *
     * @return void
     * @since 2.4.1
     *
     */
    public function reset_values( $bulletin_id ) {
        $plugin_slug = BULLETINWP_PLUGIN_SLUG;
        if ( $bulletin_id === get_theme_mod( "{$plugin_slug}-general-section-bulletin-id" ) ) {
            set_theme_mod( "{$plugin_slug}-general-section-bulletin-id", '' );
            set_theme_mod( "{$plugin_slug}-general-section-content", '' );
            set_theme_mod( "{$plugin_slug}-general-section-mobile-content", '' );
            set_theme_mod( "{$plugin_slug}-general-section-background-color", '' );
            set_theme_mod( "{$plugin_slug}-general-section-font-color", '' );
            set_theme_mod( "{$plugin_slug}-general-section-placement", 'top' );
            set_theme_mod( "{$plugin_slug}-general-section-content-max-width", '' );
            set_theme_mod( "{$plugin_slug}-general-section-text-alignment", 'center' );
            set_theme_mod( "{$plugin_slug}-general-section-font-size", '' );
            set_theme_mod( "{$plugin_slug}-general-section-font-size-mobile", '' );
        }
    }

}
