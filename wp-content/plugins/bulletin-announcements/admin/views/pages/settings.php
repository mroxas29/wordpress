<?php

defined( 'ABSPATH' ) or exit;
global $wp_roles;
$bulletin_background_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_background_color_default' );
$bulletin_font_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_font_color_default' );
$site_has_fixed_header = BULLETINWP::instance()->sql->get_option( 'site_has_fixed_header' );
$fixed_header_selector = BULLETINWP::instance()->sql->get_option( 'fixed_header_selector' );
?>

<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin' );
?>">
  <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-settings wrap' );
?>">
    <h1 class="wp-heading-inline"><?php 
esc_html_e( 'Settings', 'bulletinwp' );
?></h1>
    <hr class="wp-header-end">

    <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-common-layout ' . BULLETINWP_PLUGIN_SLUG . '-admin-settings' );
?>">
      <form class="settings-form" method="post">
        <div class="common-layout-wrapper settings">
          <div class="content">
            <div class="left-content">
              <div class="box-container p-8 mb-16">
                <!-- Default color settings -->
                <div class="heading mb-3"><?php 
esc_html_e( 'Default color settings', 'bulletinwp' );
?></div>
                <label class="mb-3"><?php 
esc_html_e( 'Setting these will apply as the default colors to all bulletins you publish', 'bulletinwp' );
?></label>

                <div class="flex mb-8">
                  <div class="flex flex-col mr-4">
                    <label class="mb-1" for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-background-color' );
?>"><?php 
esc_html_e( 'Background color', 'bulletinwp' );
?></label>
                    <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-background-color' );
?>"
                           class="color-picker-input"
                           type="text"
                           name="bulletinBackgroundColorDefault"
                           value="<?php 
echo esc_attr( $bulletin_background_color_default );
?>"
                           placeholder=""
                           data-default-color=""
                    />
                  </div>

                  <div class="flex flex-col">
                    <label class="mb-1" for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-font-color' );
?>"><?php 
esc_html_e( 'Font color', 'bulletinwp' );
?></label>
                    <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-font-color' );
?>"
                           class="color-picker-input"
                           type="text"
                           name="bulletinFontColorDefault"
                           value="<?php 
echo esc_attr( $bulletin_font_color_default );
?>"
                           placeholder=""
                           data-default-color=""
                    />
                  </div>
                </div>

                <!-- Header configuration -->
                <div class="heading mb-3"><?php 
esc_html_e( 'Header configuration', 'bulletinwp' );
?></div>

                <div class="mb-3"><?php 
esc_html_e( 'If you want to use the header bulletin under your navbar, or if you have a fixed header, you should define the css class below.', 'bulletinwp' );
?><br /><?php 
esc_html_e( 'For further instruction, please check out', 'bulletinwp' );
?> <a href="https://www.youtube.com/watch?v=oMV1_aKk-v4" target="_blank"><?php 
esc_html_e( 'this video for placing a bulletin', 'bulletinwp' );
?> <b><?php 
esc_html_e( 'under your header', 'bulletinwp' );
?></b></a> <?php 
esc_html_e( 'or', 'bulletinwp' );
?> <a href="https://www.youtube.com/watch?v=yIKVI_3dfJs" target="_blank"><?php 
esc_html_e( 'this video if you have a', 'bulletinwp' );
?> <b><?php 
esc_html_e( 'fixed header', 'bulletinwp' );
?></b></a></div>

                <!-- Header Selector -->
                <div class="font-bold mb-3"><?php 
esc_html_e( 'Header CSS selector', 'bulletinwp' );
?></div>

                <div class="form-field mb-4">
                  <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-header-selector' );
?>"
                    class="w-full form-input"
                    type="text"
                    name="fixedHeaderSelector"
                    value="<?php 
echo esc_attr( $fixed_header_selector );
?>"
                    placeholder="header.header"
                  />
                </div>

                <!-- Site has fixed header -->
                <div class="mb-8">
                  <label class="mb-3"><?php 
esc_html_e( 'My site has a fixed header', 'bulletinwp' );
?></label>

                  <div class="checkbox-wrapper toggle-switch"
                       data-checked-label="<?php 
echo esc_attr( esc_html__( 'Yes', 'bulletinwp' ) );
?>"
                       data-unchecked-label="<?php 
echo esc_attr( esc_html__( 'No', 'bulletinwp' ) );
?>"
                  >
                    <input type="checkbox" name="siteHasFixedHeader" <?php 
checked( $site_has_fixed_header );
?> />
                    <span class="label"><?php 
echo esc_html( ( $site_has_fixed_header ? esc_html__( 'Yes', 'bulletinwp' ) : esc_html__( 'No', 'bulletinwp' ) ) );
?></span>
                  </div>
                </div>

                <?php 
?>

                <!-- Export -->
                <div class="heading mb-3"><?php 
esc_html_e( 'Export', 'bulletinwp' );
?></div>

                <div class="export-bulletins-button-wrapper mb-6">
                  <button type="button"
                          class="btn btn-smaller"
                          data-default-label="<?php 
echo esc_attr( esc_html__( 'Export', 'bulletinwp' ) );
?>"
                          data-loading-label="<?php 
echo esc_attr( esc_html__( 'Exporting...', 'bulletinwp' ) );
?>"
                  >
                    <?php 
esc_html_e( 'Export', 'bulletinwp' );
?>
                  </button>
                  <div class="export-results-message mt-4" style="display: none;"></div>
                </div>

                <!-- Import -->
                <div class="heading mb-3"><?php 
esc_html_e( 'Import', 'bulletinwp' );
?></div>

                <div class="import-bulletins-button-wrapper mb-6">
                  <div class="flex flex-col">
                    <input type="file" accept=".csv" />
                    <button id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-import-bulletins-button' );
?>"
                            type="button"
                            class="btn btn-smaller"
                            data-default-label="<?php 
echo esc_attr( esc_html__( 'Import', 'bulletinwp' ) );
?>"
                            data-loading-label="<?php 
echo esc_attr( esc_html__( 'Importing...', 'bulletinwp' ) );
?>">
                      <?php 
esc_html_e( 'Import', 'bulletinwp' );
?>
                    </button>
                    <div class="import-results-message mt-4" style="display: none;"></div>
                  </div>
                </div>
              </div>

              <?php 
?>
                <?php 
$is_settings_page = true;
?>
                <?php 
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/upgrade-panel.php';
?>
              <?php 
?>
            </div>
            <div class="right-content">
              <div class="box-container py-8 px-4">
                <button class="btn-fill text-lg"
                        type="submit"
                        data-default-label="<?php 
echo esc_attr( esc_html__( 'Save', 'bulletinwp' ) );
?>"
                        data-loading-label="<?php 
echo esc_attr( esc_html__( 'Saving...', 'bulletinwp' ) );
?>"
                >
                  <?php 
esc_html_e( 'Save', 'bulletinwp' );
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
        </div>
      </form>
    </div>
  </div>
</div>
