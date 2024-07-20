<?php

/**
 * Plugin Name: Bulletin Announcements
 * Plugin URI: https://www.rocksolidplugins.com/plugins/bulletin/
 * Description: Publish a slick announcement banner notice across your website or Woocommerce shop. Extend with icons, countdowns, placement rules and more!
 * Version: 3.11.5
 * Author: Bulletin
 * Author URI: https://www.rocksolidplugins.com/
 * Text Domain: bulletinwp
 * Domain Path: /languages
 *
 */
defined( 'ABSPATH' ) or exit;
if ( function_exists( 'bulletinwp_fs' ) ) {
    bulletinwp_fs()->set_basename( false, __FILE__ );
} else {
    defined( 'BULLETINWP__FILE__' ) or define( 'BULLETINWP__FILE__', __FILE__ );
    require_once 'core/config.php';
    if ( !function_exists( 'bulletinwp_fs' ) ) {
        /**
         * bulletinwp_fs
         *
         * Bulletin freemius helper function for easy SDK access.
         *
         * @since	1.0.0
         *
         * @param	void
         * @return object $bulletinwp_fs
         */
        function bulletinwp_fs() {
            global $bulletinwp_fs;
            if ( !isset( $bulletinwp_fs ) ) {
                // Activate multisite network integration.
                if ( !defined( 'WP_FS__PRODUCT_5823_MULTISITE' ) ) {
                    define( 'WP_FS__PRODUCT_5823_MULTISITE', true );
                }
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/modules/freemius/start.php';
                $bulletinwp_fs = fs_dynamic_init( [
                    'id'             => '5823',
                    'slug'           => 'bulletinwp',
                    'premium_slug'   => 'bulletinwp-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_98562b78b1d3c58b6e301de2eba5f',
                    'is_premium'     => false,
                    'premium_suffix' => 'PRO',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => [
                        'slug'    => BULLETINWP_PLUGIN_SLUG . '-options',
                        'support' => false,
                    ],
                    'is_live'        => true,
                ] );
            }
            return $bulletinwp_fs;
        }

        // Init Freemius.
        bulletinwp_fs();
        // Signal that SDK was initiated.
        do_action( 'bulletinwp_fs_loaded' );
    }
    // Classes
    include_once 'classes/class-bulletinwp-activation.php';
    include_once 'classes/class-bulletinwp-admin.php';
    include_once 'classes/class-bulletinwp-ajax.php';
    include_once 'classes/class-bulletinwp-api.php';
    include_once 'classes/class-bulletinwp-bulletins-table.php';
    include_once 'classes/class-bulletinwp-customizer.php';
    include_once 'classes/class-bulletinwp-export.php';
    include_once 'classes/class-bulletinwp-helpers.php';
    include_once 'classes/class-bulletinwp-import.php';
    include_once 'classes/class-bulletinwp-language.php';
    include_once 'classes/class-bulletinwp-sql.php';
    final class BULLETINWP {
        private static $_instance = null;

        public $activation;

        public $admin;

        public $ajax;

        public $api;

        public $customizer;

        public $export;

        public $helpers;

        public $import;

        public $language;

        public $sql;

        public $pro;

        public function __construct() {
            if ( is_admin() ) {
                $this->activation = new BULLETINWP_Activation();
                $this->admin = new BULLETINWP_Admin();
                $this->ajax = new BULLETINWP_Ajax();
                $this->api = new BULLETINWP_API();
                $this->export = new BULLETINWP_Export();
                $this->import = new BULLETINWP_Import();
            } else {
                add_action( 'plugins_loaded', array($this, 'frontend_init') );
            }
            $this->customizer = new BULLETINWP_Customizer();
            $this->helpers = new BULLETINWP_Helpers();
            $this->language = new BULLETINWP_Language();
            $this->sql = new BULLETINWP_SQL();
        }

        /**
         * activate_plugin
         *
         * Run functions when plugin is activated
         *
         * @since	1.0.0
         *
         * @param	void
         * @return class BULLETINWP
         */
        public static function instance() {
            return ( is_null( self::$_instance ) ? self::$_instance = new BULLETINWP() : self::$_instance );
        }

        /**
         * activate_plugin
         *
         * Run functions when plugin is activated
         *
         * @since	1.0.0
         *
         * @param	void
         * @return void
         */
        public function frontend_init() {
            include_once 'classes/class-bulletinwp-frontend.php';
            new BULLETINWP_Frontend();
        }

    }

    BULLETINWP::instance();
}