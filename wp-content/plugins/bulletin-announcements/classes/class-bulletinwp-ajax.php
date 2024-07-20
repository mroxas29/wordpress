<?php

defined( 'ABSPATH' ) or exit;
class BULLETINWP_Ajax {
    private static $menu_page_base_slug = BULLETINWP_PLUGIN_SLUG . '-options';

    public function __construct() {
        $actions = [
            'bulletinwp_update_bulletin_status',
            'bulletinwp_update_bulletin',
            'bulletinwp_update_settings',
            'bulletinwp_update_status',
            'bulletinwp_export_bulletins',
            'bulletinwp_import_bulletins'
        ];
        $frontend_actions = ['bulletinwp_check_expiry'];
        foreach ( $actions as $action ) {
            /**
             * For admin ajax
             */
            add_action( "wp_ajax_{$action}", array($this, $action) );
        }
        foreach ( $frontend_actions as $action ) {
            /**
             * For front end ajax; Only enable below if any front end ajax used
             */
            add_action( "wp_ajax_{$action}", array($this, $action) );
            add_action( "wp_ajax_nopriv_{$action}", array($this, $action) );
        }
    }

    /**
     * Update bulletin status
     *
     * @since 1.0.0
     *
     * @param void
     * @return void
     */
    public function bulletinwp_update_bulletin_status() {
        check_ajax_referer( 'bulletinwp_ajax_nonce', 'ajaxNonce' );
        if ( !BULLETINWP::instance()->helpers->check_page_access_permission() ) {
            wp_send_json_error();
        }
        $bulletin_id = sanitize_text_field( $_POST['bulletinID'] );
        $status_action = sanitize_text_field( $_POST['statusAction'] );
        if ( !empty( $status_action ) ) {
            switch ( $status_action ) {
                case 'activate':
                    BULLETINWP::instance()->sql->update_bulletin_data( $bulletin_id, 'is_activated', true );
                    break;
                case 'deactivate':
                    BULLETINWP::instance()->sql->update_bulletin_data( $bulletin_id, 'is_activated', false );
                    break;
                default:
                    break;
            }
        }
        wp_send_json_success( [
            'message' => __( 'Settings saved successfully', 'bulletinwp' ),
        ] );
    }

    /**
     * Update bulletin
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function bulletinwp_update_bulletin() {
        check_ajax_referer( 'bulletinwp_ajax_nonce', 'ajaxNonce' );
        if ( !BULLETINWP::instance()->helpers->check_page_access_permission() ) {
            wp_send_json_error();
        }
        $plugin_slug = BULLETINWP_PLUGIN_SLUG;
        $bulletin = sanitize_text_field( $_POST['bulletin'] );
        $content_column_names = ['content', 'mobileContent'];
        $textarea_column_names = [];
        // Sanitize form data
        parse_str( $_POST['formData'], $mapped_form_data );
        $form_data = [];
        foreach ( $mapped_form_data as $key => $value ) {
            if ( in_array( $key, $content_column_names ) ) {
                $allowed_html = [
                    'strong' => [],
                    'em'     => [],
                    'b'      => [],
                    'i'      => [],
                    'span'   => [],
                    'sup'    => [],
                    'sub'    => [],
                    'mark'   => [],
                    'a'      => [
                        'href'   => [],
                        'target' => [],
                    ],
                    'img'    => [
                        'class' => [],
                        'style' => [],
                        'src'   => [],
                    ],
                ];
                if ( is_array( $value ) ) {
                    $updated_field = [];
                    foreach ( $value as $key_1 => $value_item ) {
                        if ( is_array( $value_item ) ) {
                            foreach ( $value_item as $key_2 => $item ) {
                                $updated_value = stripslashes( $item );
                                $updated_value = wp_kses( $updated_value, $allowed_html );
                                $updated_field[$key_1][$key_2] = $updated_value;
                            }
                        }
                    }
                    $value = $updated_field;
                } else {
                    $value = stripslashes( $value );
                    $value = wp_kses( $value, $allowed_html );
                }
            } elseif ( in_array( $key, $textarea_column_names ) ) {
                $value = sanitize_textarea_field( $value );
            } elseif ( is_array( $value ) ) {
                $value = array_map( 'sanitize_text_field', $value );
            } else {
                $value = sanitize_text_field( $value );
            }
            $form_data[$key] = $value;
        }
        $args = [];
        $is_activated = false;
        $edit_page_params = [
            'page'     => self::$menu_page_base_slug . '-edit',
            'bulletin' => '',
        ];
        $bulletin_link = '';
        $updated_data = [];
        if ( !empty( $bulletin ) ) {
            $args['id'] = $bulletin;
        }
        if ( !empty( $form_data ) && is_array( $form_data ) ) {
            $bulletin_column_names_map = [
                'isActivated'         => 'is_activated',
                'bulletinTitle'       => 'bulletin_title',
                'content'             => 'content',
                'mobileContent'       => 'mobile_content',
                'backgroundColor'     => 'background_color',
                'fontColor'           => 'font_color',
                'placement'           => 'placement',
                'headerBannerStyle'   => 'header_banner_style',
                'headerBannerScroll'  => 'header_banner_scroll',
                'contentMaxWidth'     => 'content_max_width',
                'textAlignment'       => 'text_alignment',
                'fontSize'            => 'font_size',
                'fontSizeMobile'      => 'font_size_mobile',
                'textVerticalPadding' => 'text_vertical_padding',
            ];
            // Validate the placement value
            if ( isset( $form_data['placement'] ) ) {
                $allowed_placements = ['top', 'float-bottom', 'sticky-footer'];
                if ( !in_array( $form_data['placement'], $allowed_placements ) ) {
                    $form_data['placement'] = '';
                }
            }
            foreach ( $form_data as $key => $field ) {
                if ( array_key_exists( $key, $bulletin_column_names_map ) ) {
                    if ( is_array( $field ) ) {
                        $field = serialize( $field );
                    } elseif ( in_array( strtolower( $field ), ['on', 'off'], true ) ) {
                        $field = 'on' === strtolower( $field );
                    }
                    $args['data'][$bulletin_column_names_map[$key]] = $field;
                }
            }
            if ( !empty( $args['data'] ) ) {
                $is_activated = ( isset( $args['data']['is_activated'] ) ? $args['data']['is_activated'] : false );
                $bulletin_id = BULLETINWP::instance()->sql->update_bulletin( $args );
                $bulletin_title = ( isset( $args['data']['bulletin_title'] ) && !empty( $args['data']['bulletin_title'] ) ? $args['data']['bulletin_title'] : '' );
                $edit_page_params['bulletin'] = $bulletin_id;
                $bulletin_link = BULLETINWP::instance()->helpers->get_bulletin_link( $bulletin_id );
                // Update changes on customizer fields
                if ( $bulletin_id === get_theme_mod( "{$plugin_slug}-general-section-bulletin-id" ) ) {
                    if ( isset( $args['data']['content'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-content", $args['data']['content'] );
                    }
                    if ( isset( $args['data']['mobile_content'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-mobile-content", $args['data']['mobile_content'] );
                    }
                    if ( isset( $args['data']['background_color'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-background-color", $args['data']['background_color'] );
                    }
                    if ( isset( $args['data']['font_color'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-font-color", $args['data']['font_color'] );
                    }
                    if ( isset( $args['data']['placement'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-placement", $args['data']['placement'] );
                    }
                    if ( isset( $args['data']['content_max_width'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-content-max-width", $args['data']['content_max_width'] );
                    }
                    if ( isset( $args['data']['text_alignment'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-text-alignment", $args['data']['text_alignment'] );
                    }
                    if ( isset( $args['data']['font_size'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-font-size", $args['data']['font_size'] );
                    }
                    if ( isset( $args['data']['font_size_mobile'] ) ) {
                        set_theme_mod( "{$plugin_slug}-general-section-font-size-mobile", $args['data']['font_size_mobile'] );
                    }
                }
            }
        }
        wp_send_json_success( [
            'is_activated'     => $is_activated,
            'edit_page_params' => $edit_page_params,
            'bulletin_link'    => $bulletin_link,
            'updated_data'     => $updated_data,
            'message'          => __( 'Bulletin saved', 'bulletinwp' ),
        ] );
    }

    /**
     * Update settings
     *
     * @param void
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function bulletinwp_update_settings() {
        check_ajax_referer( 'bulletinwp_ajax_nonce', 'ajaxNonce' );
        if ( !BULLETINWP::instance()->helpers->check_page_access_permission() ) {
            wp_send_json_error();
        }
        parse_str( $_POST['formData'], $form_data );
        // Sanitize form data
        $form_data = BULLETINWP::instance()->helpers->array_map_recursive( 'sanitize_text_field', $form_data );
        $all_users = get_users( 'orderby=ID' );
        $all_roles = get_editable_roles();
        if ( !empty( $form_data ) && is_array( $form_data ) ) {
            // Settings Options
            $settings_options_names_map = [
                'bulletinBackgroundColorDefault' => 'bulletin_background_color_default',
                'bulletinFontColorDefault'       => 'bulletin_font_color_default',
                'siteHasFixedHeader'             => 'site_has_fixed_header',
                'fixedHeaderSelector'            => 'fixed_header_selector',
            ];
            foreach ( $form_data as $key => $field ) {
                if ( array_key_exists( $key, $settings_options_names_map ) ) {
                    if ( is_array( $field ) ) {
                        $field = serialize( $field );
                    } elseif ( in_array( strtolower( $field ), ['on', 'off'], true ) ) {
                        $field = 'on' === strtolower( sanitize_text_field( $field ) );
                    } else {
                        $field = sanitize_text_field( $field );
                    }
                    BULLETINWP::instance()->sql->update_option( $settings_options_names_map[$key], $field );
                }
            }
        }
        wp_send_json_success( [
            'message' => __( 'Settings saved successfully', 'bulletinwp' ),
        ] );
    }

    /**
     * Update bulletin status
     *
     * @since 1.0.0
     *
     * @param void
     * @return void
     */
    public function bulletinwp_update_status() {
        check_ajax_referer( 'bulletinwp_ajax_nonce', 'ajaxNonce' );
        if ( !BULLETINWP::instance()->helpers->check_page_access_permission() ) {
            wp_send_json_error();
        }
        $bulletin_id = sanitize_text_field( $_POST['bulletinID'] );
        $status_action = sanitize_text_field( $_POST['statusAction'] );
        if ( !empty( $status_action ) ) {
            switch ( $status_action ) {
                case 'activate':
                    BULLETINWP::instance()->sql->update_bulletin_data( $bulletin_id, 'is_activated', true );
                    break;
                case 'deactivate':
                    BULLETINWP::instance()->sql->update_bulletin_data( $bulletin_id, 'is_activated', false );
                    break;
                default:
                    break;
            }
        }
        wp_send_json_success( [
            'message' => __( 'Settings saved successfully', 'bulletinwp' ),
        ] );
    }

    /**
     * Export all bulletins
     *
     * @since 3.4.0
     *
     * @param void
     * @return void
     */
    public function bulletinwp_export_bulletins() {
        check_ajax_referer( 'bulletinwp_ajax_nonce', 'ajaxNonce' );
        if ( !BULLETINWP::instance()->helpers->check_page_access_permission() ) {
            wp_send_json_error();
        }
        $filename = 'bulletins_' . date( 'Y-m-d' ) . '.csv';
        $bulletins = BULLETINWP::instance()->export->get_export_data();
        wp_send_json_success( [
            'message'   => __( 'Exporting data complete', 'bulletinwp' ),
            'filename'  => $filename,
            'bulletins' => $bulletins,
        ] );
    }

    /**
     * Import all bulletins
     *
     * @since 3.4.0
     *
     * @param void
     * @return void
     */
    public function bulletinwp_import_bulletins() {
        check_ajax_referer( 'bulletinwp_ajax_nonce', 'ajaxNonce' );
        if ( !BULLETINWP::instance()->helpers->check_page_access_permission() ) {
            wp_send_json_error();
        }
        // Sanitize form data
        $bulletins = BULLETINWP::instance()->helpers->array_map_recursive( 'sanitize_text_field', $_POST['bulletins'] );
        if ( !empty( $bulletins ) && BULLETINWP::instance()->import->import_csv_data( $bulletins ) ) {
            wp_send_json_success( [
                'message' => __( 'Importing data complete', 'bulletinwp' ),
            ] );
        }
        wp_send_json_success( [
            'message' => __( 'Invalid csv data', 'bulletinwp' ),
        ] );
    }

    /**
     * Check bulletin expiry
     *
     * @since 3.10.4
     *
     * @param void
     * @return void
     */
    public function bulletinwp_check_expiry() {
        $id = $_POST['id'];
        $expiry_date = $_POST['expiry_date'];
        $expiry_timestamp = new DateTime($expiry_date);
        if ( !empty( $timezone_string = BULLETINWP::instance()->helpers->get_timezone_string() ) ) {
            $expiry_timestamp->setTimezone( new \DateTimeZone($timezone_string) );
        }
        $current_timestamp = current_datetime();
        $is_expired = $expiry_timestamp < $current_timestamp;
        wp_send_json_success( [
            'id'           => $id,
            'expiry_date'  => $expiry_timestamp,
            'current_date' => $current_timestamp,
            'expired'      => $is_expired,
        ] );
    }

}
