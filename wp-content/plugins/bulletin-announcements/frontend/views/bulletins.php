<?php

defined( 'ABSPATH' ) or exit;
// isset( $placement ) or $placement               = 'top';
// isset( $buletins ) or $bulletins                 = [];
// isset( $active_countdown ) or $active_countdown = false;
$plugin_slug = BULLETINWP_PLUGIN_SLUG;
$bulletin_background_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_background_color_default' );
$bulletin_font_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_font_color_default' );
$site_has_fixed_header = ( $placement === 'top' ? BULLETINWP::instance()->sql->get_option( 'site_has_fixed_header' ) : false );
$fixed_header_selector = ( $placement === 'top' ? BULLETINWP::instance()->sql->get_option( 'fixed_header_selector' ) : false );
$corner_id = '';
$corner_option = '';
$lang_attribute = '';
$user_permission = ( current_user_can( 'manage_options' ) ? true : false );
$header_banner_style = '';
$header_banner_scroll = '';
$header_banner_scroll_class = '';
if ( is_customize_preview() || !empty( $bulletins ) ) {
    foreach ( $bulletins as $bulletin ) {
        if ( $placement === 'top' ) {
            $header_banner_style = $bulletin['header_banner_style'];
            $header_banner_scroll = $bulletin['header_banner_scroll'];
            if ( $header_banner_scroll === 'fixed' ) {
                $header_banner_scroll_class = "{$plugin_slug}-top-fixed";
            }
        }
        $bulletin_id = $bulletin['id'];
        ?>

    <div id="<?php 
        echo esc_attr( "{$plugin_slug}-bulletin-item-{$bulletin['id']}" );
        ?>"
         class="<?php 
        echo esc_attr( "{$plugin_slug}-bulletins {$plugin_slug}-placement-{$placement} {$corner_option} {$header_banner_scroll_class}" );
        ?>"
         data-header-banner-style="<?php 
        echo esc_attr( $header_banner_style );
        ?>"
         data-header-banner-scroll="<?php 
        echo esc_attr( $header_banner_scroll );
        ?>"
         data-site-has-fixed-header="<?php 
        echo esc_attr( ( $site_has_fixed_header ? 'true' : 'false' ) );
        ?>"
         data-fixed-header-selector="<?php 
        echo esc_attr( $fixed_header_selector );
        ?>"
    >
      <?php 
        $bulletin_title = ( isset( $bulletin['bulletin_title'] ) && !empty( $bulletin['bulletin_title'] ) ? $bulletin['bulletin_title'] : '' );
        if ( BULLETINWP::instance()->language->maybe_polylang_plugin_is_activated() && function_exists( 'pll__' ) ) {
            if ( isset( $bulletin['content'] ) && !empty( $bulletin['content'] ) ) {
                $bulletin['content'] = pll__( $bulletin['content'] );
            }
            if ( isset( $bulletin['mobile_content'] ) && !empty( $bulletin['mobile_content'] ) ) {
                $bulletin['mobile_content'] = pll__( $bulletin['mobile_content'] );
            }
        } elseif ( BULLETINWP::instance()->language->maybe_wpml_plugin_is_activated() ) {
            if ( isset( $bulletin['content'] ) && !empty( $bulletin['content'] ) ) {
                $bulletin['content'] = apply_filters(
                    'wpml_translate_single_string',
                    $bulletin['content'],
                    $plugin_slug,
                    "{$bulletin_title} ({$bulletin_id}) - Content"
                );
            }
            if ( isset( $bulletin['mobile_content'] ) && !empty( $bulletin['mobile_content'] ) ) {
                $bulletin['mobile_content'] = apply_filters(
                    'wpml_translate_single_string',
                    $bulletin['mobile_content'],
                    $plugin_slug,
                    "{$bulletin_title} ({$bulletin_id}) - Mobile Content"
                );
            }
        }
        $default_content_max_width = ( $placement === 'corner' ? '300px' : 'none' );
        $content = ( isset( $bulletin['content'] ) && !empty( $bulletin['content'] ) ? $bulletin['content'] : '' );
        $mobile_content = ( isset( $bulletin['mobile_content'] ) && !empty( $bulletin['mobile_content'] ) ? $bulletin['mobile_content'] : $content );
        $background_color = ( isset( $bulletin['background_color'] ) && !empty( $bulletin['background_color'] ) ? $bulletin['background_color'] : $bulletin_background_color_default );
        $font_color = ( isset( $bulletin['font_color'] ) && !empty( $bulletin['font_color'] ) ? $bulletin['font_color'] : $bulletin_font_color_default );
        $text_align = ( isset( $bulletin['text_alignment'] ) && !empty( $bulletin['text_alignment'] ) ? $bulletin['text_alignment'] : '' );
        $content_max_width = ( isset( $bulletin['content_max_width'] ) && !empty( $bulletin['content_max_width'] ) ? $bulletin['content_max_width'] . 'px' : $default_content_max_width );
        $font_size = ( isset( $bulletin['font_size'] ) && !empty( $bulletin['font_size'] ) ? $bulletin['font_size'] . 'px' : '' );
        $font_size_mobile = ( isset( $bulletin['font_size_mobile'] ) && !empty( $bulletin['font_size_mobile'] ) ? $bulletin['font_size_mobile'] . 'px' : '' );
        $text_vertical_padding = ( isset( $bulletin['text_vertical_padding'] ) && !empty( $bulletin['text_vertical_padding'] ) ? $bulletin['text_vertical_padding'] . 'px' : '' );
        $style = '';
        $internal_style = '';
        $additional_class = '';
        if ( !empty( $background_color ) ) {
            $style .= 'background-color: ' . $background_color . '; ';
        }
        if ( !empty( $font_color ) ) {
            $style .= 'color: ' . $font_color . '; ';
        } else {
            $style .= 'color: transparent;';
        }
        if ( !empty( $text_vertical_padding ) && $placement !== 'corner' ) {
            $style .= "padding: {$text_vertical_padding} 24px;";
        } else {
            $style .= "padding: {$text_vertical_padding} 12px;";
        }
        $bulletin_item_style = BULLETINWP::instance()->helpers->get_compressed_css_string( $style );
        $bulletin_item_float_bottom_style = BULLETINWP::instance()->helpers->get_compressed_css_string( 'max-width:' . (( $placement === 'float-bottom' && !empty( $content_max_width ) ? $content_max_width : 'none' )) );
        ?>

      <?php 
        if ( isset( $bulletin['placement'] ) && $bulletin['placement'] === $placement ) {
            ?>
        <?php 
            if ( $placement === 'corner' ) {
                ?>
          <style>
            <?php 
                echo esc_html( "#{$plugin_slug}-bulletin-item-{$bulletin['id']}" );
                ?> {
              max-width: <?php 
                echo esc_html( $content_max_width );
                ?>;
            }
            @media screen and ( max-width: 768px ) {
              <?php 
                echo esc_html( "#{$plugin_slug}-bulletin-item-{$bulletin['id']}" );
                ?> {
                max-width: 100%;
              }
            }
          </style>
        <?php 
            }
            ?>

        <div class="<?php 
            echo esc_attr( "{$plugin_slug}-bulletin-item {$additional_class}" );
            ?>"
            style="<?php 
            echo esc_attr( $bulletin_item_style );
            ?>
              <?php 
            if ( $placement === 'float-bottom' ) {
                ?>
                <?php 
                echo esc_attr( $bulletin_item_float_bottom_style );
                ?>
              <?php 
            }
            ?>
            "
            data-id="<?php 
            echo esc_attr( $bulletin['id'] );
            ?>"
            <?php 
            echo wp_kses( $lang_attribute, [] );
            ?>
        >
          <?php 
            ?>

          <div class="<?php 
            echo esc_attr( "{$plugin_slug}-main-container" );
            ?>" style="max-width: <?php 
            echo esc_attr( ( $placement !== 'float-bottom' && $placement !== 'corner' && !empty( $content_max_width ) ? $content_max_width : 'none' ) );
            ?>;">

            <!-- Countdown for corner option -->
            <?php 
            ?>

            <?php 
            ?>
              <div class="<?php 
            echo esc_attr( "{$plugin_slug}-top-container" );
            ?>" style="margin-bottom: 0;">
            <?php 
            ?>

              <?php 
            ?>

              <!-- CENTER -->
              <?php 
            ?>
                <div class="<?php 
            echo esc_attr( "{$plugin_slug}-center-container" );
            ?>">
              <?php 
            ?>

                <!-- IMAGE (left alignment) -->
                <?php 
            if ( isset( $bulletin['add_image'] ) && $bulletin['add_image'] && (isset( $bulletin['image_alignment'] ) && $bulletin['image_alignment'] == 'left') && $placement !== 'corner' ) {
                ?>
                  <?php 
                include BULLETINWP_PLUGIN_PATH . 'frontend/views/partials/pro/image.php';
                ?>
                <?php 
            }
            ?>

                <!-- Countdown -->
                <?php 
            ?>

                <!-- Message -->
                <?php 
            ?>
                  <?php 
            include BULLETINWP_PLUGIN_PATH . 'frontend/views/partials/simple-content.php';
            ?>
                <?php 
            ?>

                <?php 
            ?>

                <!-- IMAGE (right alignment)  -->
                <?php 
            if ( isset( $bulletin['add_image'] ) && $bulletin['add_image'] && (isset( $bulletin['image_alignment'] ) && $bulletin['image_alignment'] == 'right') && $placement !== 'corner' ) {
                ?>
                  <?php 
                include BULLETINWP_PLUGIN_PATH . 'frontend/views/partials/pro/image.php';
                ?>
                <?php 
            }
            ?>

              </div>

              <?php 
            ?>
            </div>

            <?php 
            ?>
          </div>

          <?php 
            if ( is_user_logged_in() && $user_permission ) {
                ?>
            <?php 
                include BULLETINWP_PLUGIN_PATH . 'frontend/views/partials/edit-link.php';
                ?>
          <?php 
            }
            ?>
        </div>
      <?php 
        }
        ?>

      <style>
      <?php 
        // Internal Style
        if ( !empty( $font_size ) ) {
            $internal_style .= "\n        #{$plugin_slug}-bulletin-item-{$bulletin['id']} {\n          font-size: {$font_size} !important;\n        }\n        #{$plugin_slug}-bulletin-item-{$bulletin['id']} p {\n          font-size: {$font_size} !important;\n        }\n        ";
        } else {
            $internal_style .= "\n        #{$plugin_slug}-bulletin-item-{$bulletin['id']} {\n          font-size: 16px !important;\n        }\n        #{$plugin_slug}-bulletin-item-{$bulletin['id']} p {\n          font-size: 16px !important;\n        }\n        ";
        }
        if ( !empty( $font_size_mobile ) ) {
            $internal_style .= "\n        @media (max-width: 767px) {\n          #{$plugin_slug}-bulletin-item-{$bulletin['id']} {\n            font-size: {$font_size_mobile} !important;\n          }\n          #{$plugin_slug}-bulletin-item-{$bulletin['id']} p {\n            font-size: {$font_size_mobile} !important;\n          }\n        }\n        ";
        } else {
            $internal_style .= "\n        @media (max-width: 767px) {\n          #{$plugin_slug}-bulletin-item-{$bulletin['id']} {\n            font-size: 16px !important;\n          }\n          #{$plugin_slug}-bulletin-item-{$bulletin['id']} p {\n            font-size: 16px !important;\n          }\n        }\n        ";
        }
        echo BULLETINWP::instance()->helpers->get_compressed_css_string( $internal_style );
        ?>
      </style>
    </div>
    <?php 
    }
}