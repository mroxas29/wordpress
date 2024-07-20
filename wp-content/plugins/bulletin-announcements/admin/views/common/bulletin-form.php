<?php

defined( 'ABSPATH' ) or exit;
// settings values
$bulletin_background_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_background_color_default' );
$bulletin_font_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_font_color_default' );
// Default values
isset( $id ) or $id = '';
isset( $link ) or $link = '';
isset( $is_activated ) or $is_activated = false;
isset( $title ) or $title = BULLETINWP::instance()->helpers->get_default_bulletin_title();
isset( $placement ) or $placement = 'top';
// Visible but disabled
isset( $add_countdown ) or $add_countdown = false;
isset( $additional_css ) or $additional_css = '';
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
// Button label
$button_status = ( empty( $id ) ? 'publish' : 'edit' );
$default_label = ( empty( $id ) ? esc_html__( 'Publish Bulletin', 'bulletinwp' ) : esc_html__( 'Save Bulletin', 'bulletinwp' ) );
$loading_label = (( empty( $id ) ? esc_html__( 'Publishing', 'bulletinwp' ) : esc_html__( 'Saving', 'bulletinwp' ) )) . '...';
?>

<div class="mb-8">
  <div class="mb-4">
    <label class="heading mb-0 mr-2" for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-title' );
?>"><?php 
esc_html_e( 'Title', 'bulletinwp' );
?></label>
    <span class="text-xs"><?php 
esc_html_e( '(only visible for you)', 'bulletinwp' );
?></span>
  </div>

  <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-title' );
?>"
         class="w-full"
         type="text"
         name="bulletinTitle"
         value="<?php 
echo esc_attr( $title );
?>"
         placeholder="<?php 
echo esc_attr( esc_html__( 'Add title', 'bulletinwp' ) );
?>"
  />
</div>

<div class="content">
  <div class="left-content">

    <!-- Choose bulletin type -->
    <div class="box-container p-4 md:p-8">
      <h3 class="mb-4"><?php 
esc_html_e( 'Choose bulletin type', 'bulletinwp' );
?></h3>

      <div class="radio-group-wrapper flex flex-wrap">
        <div class="w-1/2 lg:w-auto mr-4 radio-group">
          <div class="bulletin-type-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-top' );
?>"
                   type="radio"
                   name="placement"
                   value="top"
                   data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-display-type-header-note-element, #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-option, #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-scroll-type' );
?>"
                   <?php 
checked( $placement === 'top' );
?>
            />

            <label for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-top' );
?>">
              <div class="type-name"><?php 
esc_html_e( 'Header', 'bulletinwp' );
?></div>

              <div class="bulletin-type-image">
                <div class="border"></div>
                <div class="checked-icon">
                  <img src="<?php 
echo esc_url( $images_dir . '/checked.svg' );
?>" alt="">
                </div>
                <img src="<?php 
echo esc_url( $images_dir . '/tooltips/tooltip-header.svg' );
?>" alt="">
              </div>
            </label>
          </div>
        </div>

        <div class="w-1/2 lg:w-auto mr-4 radio-group">
          <div class="bulletin-type-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-float-bottom' );
?>"
                   type="radio"
                   name="placement"
                   value="float-bottom"
                   data-show-elements=""
                   data-hide-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-display-type-header-note-element, #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-option, #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-scroll-type' );
?>"
                   <?php 
checked( $placement === 'float-bottom' );
?>
            />

            <label for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-float-bottom' );
?>">
              <div class="type-name"><?php 
esc_html_e( 'Floating at bottom', 'bulletinwp' );
?></div>

              <div class="bulletin-type-image">
                <div class="border"></div>
                <div class="checked-icon">
                  <img src="<?php 
echo esc_url( $images_dir . '/checked.svg' );
?>" alt="">
                </div>
                <img src="<?php 
echo esc_url( $images_dir . '/tooltips/tooltip-floating.svg' );
?>" alt="">
              </div>
            </label>
          </div>
        </div>

        <div class="w-1/2 lg:w-auto mr-4 radio-group">
          <div class="bulletin-type-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-sticky-footer' );
?>"
                   type="radio"
                   name="placement"
                   value="sticky-footer"
                   data-show-elements=""
                   data-hide-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-display-type-header-note-element, #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-option, #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-scroll-type' );
?>"
                   <?php 
checked( $placement === 'sticky-footer' );
?>
            />

            <label for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-sticky-footer' );
?>">
              <div class="type-name"><?php 
esc_html_e( 'Sticky footer', 'bulletinwp' );
?></div>

              <div class="bulletin-type-image">
                <div class="border"></div>
                <div class="checked-icon">
                  <img src="<?php 
echo esc_url( $images_dir . '/checked.svg' );
?>" alt="">
                </div>
                <img src="<?php 
echo esc_url( $images_dir . '/tooltips/tooltip-sticky.svg' );
?>" alt="">
              </div>
            </label>
          </div>
        </div>

        <div class="w-1/2 lg:w-auto radio-group <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>">
          <div class="bulletin-type-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-corner' );
?>"
                   type="radio"
                   name="placement"
                   value="<?php 
echo ( bulletinwp_fs()->is__premium_only() ? 'corner' : '' );
?>"
                   data-show-elements="<?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '#' . BULLETINWP_PLUGIN_SLUG . '-display-corner-option,' : '' ) );
?> <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '#' . BULLETINWP_PLUGIN_SLUG . '-placement-corner-note' : '' ) );
?>"
                   data-hide-elements="<?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '#' . BULLETINWP_PLUGIN_SLUG . '-text-alignment,' : '' ) );
?> <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '#' . BULLETINWP_PLUGIN_SLUG . '-default-placement-note,' : '' ) );
?> <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '#' . BULLETINWP_PLUGIN_SLUG . '-text-vertical-padding-wrapper,' : '' ) );
?> <?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-display-type-header-note-element' );
?> <?php 
echo esc_attr( ', #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-option' );
?> <?php 
echo esc_attr( ', #' . BULLETINWP_PLUGIN_SLUG . '-display-header-top-scroll-type' );
?>, <?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-add-image-wrapper' );
?>"
                   <?php 
checked( $placement === 'corner' );
?>
                   <?php 
echo esc_html( ( bulletinwp_fs()->is__premium_only() ? '' : 'disabled' ) );
?>
            />

            <label for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-corner' );
?>">
              <div class="type-name flex items-center justify-center">
                <?php 
esc_html_e( 'Corner', 'bulletinwp' );
?>

                <?php 
?>
                  <div class="pro-pill">PRO</div>
                <?php 
?>
              </div>

              <div class="bulletin-type-image">
                <div class="border"></div>
                <div class="checked-icon">
                  <img src="<?php 
echo esc_url( $images_dir . '/checked.svg' );
?>" alt="">
                </div>
                <img src="<?php 
echo esc_url( $images_dir . '/tooltips/tooltip-corner.svg' );
?>" alt="">
              </div>
            </label>
          </div>
        </div>

      </div>

      <div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-display-type-header-note-element' );
?>"
           class="mt-4"
           style="display: <?php 
echo esc_attr( ( $placement === 'top' ? 'block' : 'none' ) );
?>"
      >
        <?php 
esc_html_e( 'NOTE', 'bulletinwp' );
?>:&nbsp;<?php 
esc_html_e( 'if this site uses a fixed header, ', 'bulletinwp' );
?>
        <a href="<?php 
echo esc_url( add_query_arg( [
    'page' => BULLETINWP_PLUGIN_SLUG . '-options-settings',
], 'admin.php' ) );
?>" class="text-orange-100"><?php 
esc_html_e( 'please add the html tag in settings', 'bulletinwp' );
?></a>
      </div>
    </div>

    <!-- Tabs options -->
    <div class="tabs-wrapper mt-8">
      <div class="tabs">

        <div class="tab-item active"
              data-tab="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-message-tab' );
?>">
          <div class="text-base uppercase font-bold">
            <?php 
esc_html_e( 'Message', 'bulletinwp' );
?>
          </div>
          <div class="text-sm">
            <?php 
esc_html_e( 'What you want to say', 'bulletinwp' );
?>
          </div>
        </div>

        <div class="tab-item"
              data-tab="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-display-tab' );
?>">
          <div class="text-base uppercase font-bold">
            <?php 
esc_html_e( 'Display Options', 'bulletinwp' );
?>
          </div>
          <div class="text-sm">
            <?php 
esc_html_e( 'How you want it to display', 'bulletinwp' );
?>
          </div>
        </div>

        <div class="tab-item"
              data-tab="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-design-tab' );
?>">
          <div class="text-base uppercase font-bold">
            <?php 
esc_html_e( 'Design', 'bulletinwp' );
?>
          </div>
          <div class="text-sm">
            <?php 
esc_html_e( 'Customize your bulletin', 'bulletinwp' );
?>
          </div>
        </div>

        <div class="tab-item"
              data-tab="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-placement-tab' );
?>">
          <div class="text-base uppercase font-bold">
            <?php 
esc_html_e( 'Placement', 'bulletinwp' );
?>
          </div>
          <div class="text-sm">
            <?php 
esc_html_e( 'Where you want to show it', 'bulletinwp' );
?>
          </div>
        </div>

        <div class="tab-item"
              data-tab="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-expiry-tab' );
?>">
          <div class="text-base uppercase font-bold">
            <?php 
esc_html_e( 'Expiry', 'bulletinwp' );
?>
          </div>
          <div class="text-sm">
            <?php 
esc_html_e( 'Set expiry and countdown', 'bulletinwp' );
?>
          </div>
        </div>

        <div class="tab-item"
              data-tab="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-advanced-tab' );
?>">
          <div class="text-base uppercase font-bold">
            <?php 
esc_html_e( 'Advanced', 'bulletinwp' );
?>
          </div>
          <div class="text-sm">
            <?php 
esc_html_e( 'Add custom CSS & more', 'bulletinwp' );
?>
          </div>
        </div>

        <?php 
if ( is_multisite() && is_main_site() ) {
    ?>
          <div class="tab-item"
                data-tab="<?php 
    echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-network-tab' );
    ?>">
            <div class="text-base uppercase font-bold">
              <?php 
    esc_html_e( 'WP Network', 'bulletinwp' );
    ?>
            </div>
            <div class="text-sm">
              <?php 
    esc_html_e( 'Configure bulletins on networks', 'bulletinwp' );
    ?>
            </div>
          </div>
        <?php 
}
?>
      </div>

      <div class="tabs-content">
        <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/tabs/message.php';
?>
        <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/tabs/display.php';
?>
        <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/tabs/design.php';
?>
        <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/tabs/placement.php';
?>
        <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/tabs/expiry.php';
?>
        <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/tabs/advanced.php';
?>
        <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/tabs/wp-network.php';
?>
      </div>
    </div>

    <?php 
?>
      <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/upgrade-panel.php';
?>
    <?php 
?>
  </div>

  <div class="right-content">
    <div class="box-container py-8 px-4">
      <!-- Preview -->
      <a href="<?php 
echo esc_url( $link );
?>"
         class="btn view-button mb-8"
         target="_blank"
         style="display: <?php 
echo esc_attr( ( !empty( $link ) ? 'inline-flex' : 'none' ) );
?>; width: 80%;"
      >
        <?php 
echo esc_html( ( $is_activated ? esc_html__( 'View', 'bulletinwp' ) : esc_html__( 'Preview', 'bulletinwp' ) ) );
?>
        <img src="<?php 
echo esc_url( $images_dir . '/angle.svg' );
?>" alt="">
      </a>

      <!-- Active Switch -->
      <div class="mb-8">
        <div class="checkbox-wrapper toggle-switch active-data-label"
             data-checked-label="<?php 
echo esc_attr( esc_html__( 'Active', 'bulletinwp' ) );
?>"
             data-unchecked-label="<?php 
echo esc_attr( esc_html__( 'Inactive', 'bulletinwp' ) );
?>"
        >
          <input type="checkbox" name="isActivated" <?php 
checked( $is_activated );
?>  <?php 
echo esc_html( ( isset( $add_schedule ) && $add_schedule ? 'disabled' : '' ) );
?> />
          <span class="label active-switch-label"><?php 
echo esc_html( ( $is_activated ? esc_html__( 'Active', 'bulletinwp' ) : esc_html__( 'Inactive', 'bulletinwp' ) ) );
?></span>
        </div>
      </div>

      <?php 
?>

      <!-- Submit -->
      <button class="btn-fill text-lg"
              type="submit"
              data-button-status="<?php 
echo esc_attr( $button_status );
?>"
              data-default-label="<?php 
echo esc_attr( $default_label );
?>"
              data-loading-label="<?php 
echo esc_attr( $loading_label );
?>"
      >
        <?php 
echo esc_html( $default_label );
?>
      </button>
      <div class="form-message mt-8" style="display: none;"></div>
    </div>

    <!-- Right panel content -->
    <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/right-panel.php';
?>

  </div>
</div>
