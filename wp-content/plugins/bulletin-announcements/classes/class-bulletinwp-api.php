<?php

defined( 'ABSPATH' ) or exit;

class BULLETINWP_API {
  public function __construct() {
  }

  /**
   * Check if admin page is in plugin
   *
   * @param void
   *
   * @return bool
   * @since 1.0.0
   *
   */
  public function is_page_in_plugin() {
    global $pagenow;

    return ( 'admin.php' == $pagenow ) && ( isset( $_GET['page'] ) ) && ( strpos( $_GET['page'], BULLETINWP_PLUGIN_SLUG . '-options' ) === 0 );
  }
}
