<?php

defined( 'ABSPATH' ) or exit;

$bulletins_table = new BULLETINWP_Bulletins_Table();

?>

<div id="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin' ) ?>">
  <div class="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-bulletins wrap' ) ?>">
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Bulletins', 'bulletinwp' ) ?></h1>

    <a href="<?php echo esc_url( add_query_arg( [ 'page' => BULLETINWP_PLUGIN_SLUG . '-options-add-new' ], 'admin.php' ) ) ?>"
       class="page-title-action btn-no-underline"
    >
      <?php esc_html_e( 'Add New', 'bulletinwp' ); ?>
    </a>

    <hr class="wp-header-end">

    <div class="bulletins pr-2">
      <form id="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-bulletins-form' ) ?>"
            class="bulletins-form"
            method="get">
        <input type="hidden" name="page" value="<?php echo esc_html( sanitize_text_field( $_REQUEST['page'] ) ) ?>" />
        <input type="hidden"
               name="referrer"
               value="<?php echo esc_url( add_query_arg( [ 'page' => BULLETINWP_PLUGIN_SLUG . '-options' ], 'admin.php' ) ) ?>"
        />
        <?php
        $bulletins_table->views();
        $bulletins_table->prepare_items();
        $bulletins_table->display();
        ?>
      </form>
    </div>
  </div>
</div>
