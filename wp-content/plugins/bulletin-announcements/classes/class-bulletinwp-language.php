<?php

defined( 'ABSPATH' ) or exit;
class BULLETINWP_Language {
    public function __construct() {
        add_action( 'init', array($this, 'load_text_domain') );
        add_action( 'init', array($this, 'register_polylang_plugin_string_translations') );
        add_action( 'init', array($this, 'register_wpml_plugin_string_translations') );
    }

    /**
     * Check if Polylang plugin is activated
     *
     * @since 3.0.0
     *
     * @param void
     * @return bool
     */
    public function maybe_polylang_plugin_is_activated() {
        return function_exists( 'pll_the_languages' );
    }

    /**
     * Check if WPML plugin is activated
     *
     * @since 3.0.0
     *
     * @param void
     * @return bool
     */
    public function maybe_wpml_plugin_is_activated() {
        return is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' );
    }

    /**
     * Get locale
     *
     * @since 3.0.0
     *
     * @param void
     * @return string
     */
    public function get_locale() {
        $locale = get_locale();
        if ( function_exists( 'get_user_locale' ) && is_admin() ) {
            $locale = get_user_locale();
        }
        if ( function_exists( 'get_user_locale' ) && isset( $_GET['_locale'] ) && 'user' === $_GET['_locale'] ) {
            $locale = get_user_locale();
        }
        if ( !empty( $_GET['wp_lang'] ) && !empty( $GLOBALS['pagenow'] ) && 'wp-login.php' === $GLOBALS['pagenow'] ) {
            $locale = sanitize_text_field( $_GET['wp_lang'] );
        }
        return $locale;
    }

    /**
     * Load plugin text domain
     *
     * @since 3.0.0
     *
     * @param void
     * @return void
     */
    public function load_text_domain() {
        $locale = $this->get_locale();
        $mo_file = "bulletin-{$locale}.mo";
        // Try to load from the languages directory first.
        if ( load_textdomain( BULLETINWP_PLUGIN_SLUG, WP_LANG_DIR . '/plugins/' . $mo_file ) ) {
            return true;
        }
        // Load from plugin languages folder.
        return load_textdomain( BULLETINWP_PLUGIN_SLUG, BULLETINWP_PLUGIN_PATH . 'languages/' . $mo_file );
    }

    /**
     * Register string translations for Polylang plugin
     *
     * @since 3.0.0
     *
     * @param void
     * @return void
     */
    public function register_polylang_plugin_string_translations() {
        if ( $this->maybe_polylang_plugin_is_activated() && function_exists( 'pll_register_string' ) ) {
            $bulletins = BULLETINWP::instance()->sql->get_all_bulletins();
            if ( !empty( $bulletins ) ) {
                foreach ( $bulletins as $bulletin ) {
                    $bulletin_id = $bulletin['id'];
                    $bulletin_title = ( isset( $bulletin['bulletin_title'] ) && !empty( $bulletin['bulletin_title'] ) ? $bulletin['bulletin_title'] : '' );
                    if ( isset( $bulletin['content'] ) && !empty( $bulletin['content'] ) ) {
                        pll_register_string(
                            "{$bulletin_title} ({$bulletin_id}) - Content",
                            $bulletin['content'],
                            'Bulletin',
                            true
                        );
                    }
                    if ( isset( $bulletin['mobile_content'] ) && !empty( $bulletin['mobile_content'] ) ) {
                        pll_register_string(
                            "{$bulletin_title} ({$bulletin_id}) - Mobile Content",
                            $bulletin['mobile_content'],
                            'Bulletin',
                            true
                        );
                    }
                }
            }
        }
    }

    /**
     * Register string translations for WPML plugin
     *
     * @since 3.0.0
     *
     * @param void
     * @return void
     */
    public function register_wpml_plugin_string_translations() {
        if ( $this->maybe_wpml_plugin_is_activated() ) {
            $bulletins = BULLETINWP::instance()->sql->get_all_bulletins();
            if ( !empty( $bulletins ) ) {
                foreach ( $bulletins as $bulletin ) {
                    $bulletin_id = $bulletin['id'];
                    $bulletin_title = ( isset( $bulletin['bulletin_title'] ) && !empty( $bulletin['bulletin_title'] ) ? $bulletin['bulletin_title'] : '' );
                    if ( isset( $bulletin['content'] ) && !empty( $bulletin['content'] ) ) {
                        do_action(
                            'wpml_register_single_string',
                            BULLETINWP_PLUGIN_SLUG,
                            "{$bulletin_title} ({$bulletin_id}) - Content",
                            $bulletin['content']
                        );
                    }
                    if ( isset( $bulletin['mobile_content'] ) && !empty( $bulletin['mobile_content'] ) ) {
                        do_action(
                            'wpml_register_single_string',
                            BULLETINWP_PLUGIN_SLUG,
                            "{$bulletin_title} ({$bulletin_id}) - Mobile Content",
                            $bulletin['mobile_content']
                        );
                    }
                }
            }
        }
    }

}
