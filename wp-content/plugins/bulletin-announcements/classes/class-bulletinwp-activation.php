<?php

defined( 'ABSPATH' ) or exit;

class BULLETINWP_Activation {
  private static $bulletins_table_name = 'bulletinwp_bulletins';
  private static $options_table_name   = 'bulletinwp_options';

  public function __construct() {
    register_activation_hook( BULLETINWP__FILE__, array( $this, 'activate_plugin' ) );
    register_deactivation_hook( BULLETINWP__FILE__, array( $this, 'deactivate_plugin' ) );

    // This will only be executed if the free or pro version is not activated
    bulletinwp_fs()->add_action( 'after_uninstall', array( $this, 'uninstall_plugin' ) );

    add_action( 'init', array( $this, 'child_site_create_plugin_tables' ) );
    add_filter( 'wpmu_drop_tables', array( $this, 'delete_site' ) );
  }

  /**
   * Run functions when plugin is activated
   *
   * @param void
   *
   * @return void
   * @since 1.0.0
   *
   */
  public function activate_plugin( $network_wide ) {
    // Set transient for welcome screen redirect
    set_transient( BULLETINWP_PLUGIN_WELCOME_PAGE_TRANSIENT_KEY, true, 30 );

    if ( is_multisite() && $network_wide ) {
      global $wpdb;

      $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

      foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );

        $this->create_plugin_tables();

        restore_current_blog();
      }
    } else {
      $this->create_plugin_tables();
    }

    flush_rewrite_rules();
  }

  /**
   * Run functions when plugin is deactivated
   *
   * @param void
   *
   * @return void
   * @since 1.0.0
   *
   */
  public function deactivate_plugin() {
    flush_rewrite_rules();
  }

  /**
   * Run functions when plugin is unsintalled
   *
   * @param void
   *
   * @return void
   * @since 1.0.0
   *
   */
  public function uninstall_plugin() {
    if ( is_multisite() ) {
      global $wpdb;

      $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

      foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );

        $this->delete_plugin_tables();

        restore_current_blog();
      }
    } else {
      $this->delete_plugin_tables();
    }
  }

  /**
   * Create new site
   *
   * @return void
   * @since 3.8.0
   *
   */
  public function child_site_create_plugin_tables() {
    $plugin_file_path = BULLETINWP::instance()->helpers->get_plugin_file_path();

    if ( ! empty( $plugin_file_path )
         && is_plugin_active_for_network( $plugin_file_path )
    ) {
      $this->create_plugin_tables();
    }
  }

  /**
   * Delete site
   *
   * @param array $tables
   *
   * @return array $tables
   * @since 1.0.0
   *
   */
  public function delete_site( $tables ) {
    global $table_prefix;

    $tables[] = $table_prefix . self::$bulletins_table_name;
    $tables[] = $table_prefix . self::$options_table_name;

    return $tables;
  }

  /**
   * Create plugin tables
   *
   * @param void
   *
   * @return void
   * @since 1.0.0
   *
   */
  private function create_plugin_tables() {
    if ( BULLETINWP::instance()->sql->maybe_create_bulletins_table() ) {
      // Create bulletins table
      BULLETINWP::instance()->sql->create_bulletins_table();

      // Insert columns on bulletins table
      BULLETINWP::instance()->sql->bulletins_table_insert_columns();
    }

    if ( BULLETINWP::instance()->sql->maybe_create_options_table() ) {
      // Create options table
      BULLETINWP::instance()->sql->create_options_table();
    }
  }

  /**
   * Delete plugin tables
   *
   * @param void
   *
   * @return void
   * @since 1.0.0
   *
   */
  private function delete_plugin_tables() {
    // Delete bulletins table
    BULLETINWP::instance()->sql->delete_bulletins_table();

    // Delete options table
    BULLETINWP::instance()->sql->delete_options_table();
  }
}
