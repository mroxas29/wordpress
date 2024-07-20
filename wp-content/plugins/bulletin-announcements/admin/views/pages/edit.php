<?php

defined( 'ABSPATH' ) or exit;
if ( isset( $_GET['bulletin'] ) && !empty( $_GET['bulletin'] ) ) {
    $bulletin_id = sanitize_text_field( $_GET['bulletin'] );
    $bulletin = BULLETINWP::instance()->sql->get_bulletin( $bulletin_id );
    if ( !empty( $bulletin ) ) {
        // Set bulletin form data
        $id = $bulletin_id;
        $link = BULLETINWP::instance()->helpers->get_bulletin_link( $bulletin_id );
        if ( isset( $bulletin['is_activated'] ) ) {
            $is_activated = $bulletin['is_activated'];
        }
        if ( isset( $bulletin['bulletin_title'] ) ) {
            $title = $bulletin['bulletin_title'];
        }
        if ( isset( $bulletin['content'] ) ) {
            $content = $bulletin['content'];
        }
        if ( isset( $bulletin['mobile_content'] ) ) {
            $mobile_content = $bulletin['mobile_content'];
        }
        if ( isset( $bulletin['background_color'] ) ) {
            $background_color = $bulletin['background_color'];
        }
        if ( isset( $bulletin['font_color'] ) ) {
            $font_color = $bulletin['font_color'];
        }
        if ( isset( $bulletin['placement'] ) ) {
            $placement = $bulletin['placement'];
        }
        if ( isset( $bulletin['header_banner_style'] ) ) {
            $header_banner_style = $bulletin['header_banner_style'];
        }
        if ( isset( $bulletin['header_banner_scroll'] ) ) {
            $header_banner_scroll = $bulletin['header_banner_scroll'];
        }
        if ( isset( $bulletin['content_max_width'] ) ) {
            $content_max_width = $bulletin['content_max_width'];
        }
        if ( isset( $bulletin['text_alignment'] ) ) {
            $text_alignment = $bulletin['text_alignment'];
        }
        if ( isset( $bulletin['font_size'] ) ) {
            $font_size = $bulletin['font_size'];
        }
        if ( isset( $bulletin['font_size_mobile'] ) ) {
            $font_size_mobile = $bulletin['font_size_mobile'];
        }
        if ( isset( $bulletin['text_vertical_padding'] ) ) {
            $text_vertical_padding = $bulletin['text_vertical_padding'];
        }
    }
}
?>

<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin' );
?>">
  <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-edit wrap' );
?>">
    <h1 class="wp-heading-inline"><?php 
esc_html_e( 'Edit bulletin', 'bulletinwp' );
?></h1>

    <hr class="wp-header-end">

    <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-common-layout ' . BULLETINWP_PLUGIN_SLUG . '-admin-edit' );
?>">
      <form class="bulletin-form" method="post">
        <div class="common-layout-wrapper edit">
          <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/bulletin-form.php';
?>
        </div>
      </form>
    </div>
  </div>
</div>
