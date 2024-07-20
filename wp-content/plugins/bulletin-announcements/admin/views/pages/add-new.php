<?php

defined( 'ABSPATH' ) or exit;

// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';

?>

<div id="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin' ) ?>">
  <div class="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-add-new wrap' ) ?>">
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Add new bulletin', 'bulletinwp' ) ?></h1>

    <hr class="wp-header-end">

    <div class="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-common-layout' ) ?>">
      <form class="bulletin-form" method="post">
        <div class="common-layout-wrapper add-new">
          <?php include_once( BULLETINWP_PLUGIN_PATH . 'admin/views/common/bulletin-form.php' ); ?>
        </div>
      </form>
    </div>
  </div>
</div>
