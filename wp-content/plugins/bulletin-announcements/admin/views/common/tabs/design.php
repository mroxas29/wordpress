<?php

defined( 'ABSPATH' ) or exit;
include_once BULLETINWP_PLUGIN_PATH . 'admin/views/common/constants/icon-options.php';
// settings values
$bulletin_background_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_background_color_default' );
$bulletin_font_color_default = BULLETINWP::instance()->sql->get_option( 'bulletin_font_color_default' );
// Default values
isset( $font_size ) or $font_size = '';
isset( $font_size_mobile ) or $font_size_mobile = '';
isset( $text_vertical_padding ) or $text_vertical_padding = '';
if ( isset( $background_color ) ) {
    $background_color = $background_color;
} elseif ( !isset( $background_color ) && !empty( $bulletin_background_color_default ) ) {
    $background_color = $bulletin_background_color_default;
} else {
    $background_color = '#d33b19';
}
if ( isset( $font_color ) ) {
    $font_color = $font_color;
} else {
    if ( !isset( $font_color ) && !empty( $bulletin_font_color_default ) ) {
        $font_color = $bulletin_font_color_default;
    } else {
        $font_color = '#ffffff';
    }
}
// Visible but disabled
isset( $add_icon ) or $add_icon = 'none';
isset( $add_image ) or $add_image = false;
isset( $fonts ) or $fonts = 'inherit';
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
?>

<!-- TAB - Design -->
<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-design-tab' );
?>" class="tab-pane">
    <div class="flex items-center mb-8 md:mb-12">
        <div class="heading-icon mr-4">
        <img src="<?php 
echo esc_url( $images_dir . '/tab-icon/message.svg' );
?>" alt="">
        </div>

        <div class="tab-heading">
        <?php 
esc_html_e( 'Design', 'bulletinwp' );
?>
        </div>
    </div>

    <div>
        <div class="heading">
        <?php 
esc_html_e( 'Colors', 'bulletinwp' );
?>
        </div>

        <hr class="my-4">

        <div class="flex flex-col md:flex-row mb-4">
          <div class="form-field form-field-color-picker flex flex-col mr-0 md:mr-4 mb-4 md:mb-0 is-required">
              <label class="mb-2" for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-background-color' );
?>"><?php 
_e( 'Background color', 'bulletinwp' );
?></label>
              <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-background-color' );
?>"
                      class="form-input color-picker-input"
                      type="text"
                      name="backgroundColor"
                      value="<?php 
echo esc_attr( $background_color );
?>"
                      placeholder=""
                      data-default-color=""
              />
          </div>

          <div class="form-field form-field-color-picker flex flex-col is-required">
              <label class="mb-2" for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-font-color' );
?>"><?php 
_e( 'Font color', 'bulletinwp' );
?></label>
              <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-font-color' );
?>"
                      class="form-input color-picker-input"
                      type="text"
                      name="fontColor"
                      value="<?php 
echo esc_attr( $font_color );
?>"
                      placeholder=""
                      data-default-color=""
              />
          </div>
        </div>
    </div>

    <div class="mt-8">
        <div>
        <span class="heading mr-2"> <?php 
esc_html_e( 'Font Size', 'bulletinwp' );
?> </span>
        <span class="text-xs"><?php 
esc_html_e( '(in px, leave blank for default font-size)', 'bulletinwp' );
?></span>
        </div>

        <hr class="my-4">

        <div class="flex flex-wrap -mx-4 mb-8">
        <div class="w-full lg:w-auto mb-4 lg:mb-0 px-4">
            <label for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-font-size' );
?>"><?php 
esc_html_e( 'Desktop', 'bulletinwp' );
?></label>
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-font-size' );
?>"
                    class="w-full"
                    type="number"
                    name="fontSize"
                    value="<?php 
echo esc_attr( $font_size );
?>"
                    placeholder="16"
            />
        </div>

        <div class="w-full lg:w-auto mb-4 lg:mb-0 px-4">
            <label for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-mobile-font-size' );
?>"><?php 
esc_html_e( 'Mobile', 'bulletinwp' );
?></label>
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-mobile-font-size' );
?>"
                    class="w-full"
                    type="number"
                    name="fontSizeMobile"
                    value="<?php 
echo esc_attr( $font_size_mobile );
?>"
                    placeholder="16"
            />
        </div>
        </div>
    </div>

    <div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-text-vertical-padding-wrapper' );
?>"
        class="mt-8">
        <div>
        <span class="heading mr-2"> <?php 
esc_html_e( 'Text Vertical Padding', 'bulletinwp' );
?> </span>
        <span class="text-xs"><?php 
esc_html_e( '(in px, leave blank for default vertical padding)', 'bulletinwp' );
?></span>
        </div>

        <hr class="my-4">

        <div class="flex flex-wrap -mx-4">
        <div class="w-full lg:w-auto mb-4 lg:mb-0 px-4">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-text-vertical-padding' );
?>"
                    class="w-full"
                    type="number"
                    name="textVerticalPadding"
                    value="<?php 
echo esc_attr( $text_vertical_padding );
?>"
                    placeholder="12"
            />
        </div>
        </div>
    </div>

    <!-- ADD ICON -->
    <div class="mt-8">
      <div class="heading flex items-center">
        <?php 
esc_html_e( 'Add icon', 'bulletinwp' );
?>

        <?php 
?>
          <div class="pro-pill">PRO</div>
        <?php 
?>
      </div>

      <hr class="my-4">

      <!-- Radio Group -->
      <div class="radio-group-wrapper flex mb-4 <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>">
        <div class="mr-4">
          <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-add-icon-none' );
?>"
                  type="radio"
                  name="addIcon"
                  value="none"
                  data-show-elements=""
                  <?php 
checked( $add_icon === 'none' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'None', 'bulletinwp' );
?></span>
          </label>
        </div>

        <div class="mr-4">
          <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-add-icon-from-set' );
?>"
                  type="radio"
                  name="addIcon"
                  value="from-set"
                  data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-icon-from-set-element' );
?>"
                  <?php 
checked( $add_icon === 'from-set' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Original set', 'bulletinwp' );
?></span>
          </label>
        </div>

        <div class="mr-4">
          <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-add-icon-from-set-solid' );
?>"
                  type="radio"
                  name="addIcon"
                  value="from-set-solid"
                  data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-icon-from-set-element' );
?>"
                  <?php 
checked( $add_icon === 'from-set-solid' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Solid set', 'bulletinwp' );
?></span>
          </label>
        </div>

        <div class="mr-4">
          <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-add-icon-from-set-outline' );
?>"
                  type="radio"
                  name="addIcon"
                  value="from-set-outline"
                  data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-icon-from-set-element' );
?>"
                  <?php 
checked( $add_icon === 'from-set-outline' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Outline set', 'bulletinwp' );
?></span>
          </label>
        </div>

        <div>
          <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-add-icon-upload-own' );
?>"
                    type="radio"
                    name="addIcon"
                    value="upload-own"
                    data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-upload-icon-element' );
?>"
                    <?php 
checked( $add_icon === 'upload-own' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Upload my own', 'bulletinwp' );
?></span>
          </label>
        </div>
      </div>

      <?php 
?>
    </div>

    <!-- ADD IMAGE -->
    <div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-add-image-wrapper' );
?>"
            class="mt-8"
            style="display: <?php 
echo esc_attr( ( $placement !== 'corner' ? 'block' : 'none' ) );
?>;"
    >
        <div class="heading flex items-center">
        <?php 
esc_html_e( 'Add image', 'bulletinwp' );
?>

        <?php 
?>
            <div class="pro-pill">PRO</div>
        <?php 
?>
        </div>

        <hr class="my-4">

        <!-- Toggle -->
        <div class="checkbox-wrapper toggle-switch <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>"
            data-checked-label="<?php 
echo esc_attr( esc_html__( 'Yes', 'bulletinwp' ) );
?>"
            data-unchecked-label="<?php 
echo esc_attr( esc_html__( 'No', 'bulletinwp' ) );
?>"
            data-hide-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-upload-image-element' );
?>, #<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-image-alignment-element' );
?>, #<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-image-max-width-element' );
?>"
        >
        <input type="checkbox" name="addImage" <?php 
checked( $add_image );
?> />
        <span class="label"><?php 
echo esc_html( ( $add_image ? esc_html__( 'Yes', 'bulletinwp' ) : esc_html__( 'No', 'bulletinwp' ) ) );
?></span>
        </div>

        <?php 
?>
    </div>

    <!-- FONTS -->
    <div class="mt-8">
        <div class="heading flex items-center">
        <?php 
esc_html_e( 'Fonts', 'bulletinwp' );
?>

        <?php 
?>
            <div class="pro-pill">PRO</div>
        <?php 
?>
        </div>

        <hr class="my-4">

        <!-- Radio group -->
        <div class="radio-group-wrapper flex mb-4 <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>">
        <div class="mr-4">
            <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-fonts-inherit' );
?>"
                    type="radio"
                    name="fonts"
                    value="inherit"
                    <?php 
checked( $fonts === 'inherit' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Inherit from site', 'bulletinwp' );
?></span>
            </label>
        </div>

        <div class="mr-4">
            <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-fonts-google-fonts' );
?>"
                    type="radio"
                    name="fonts"
                    value="google-fonts"
                    data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-google-fonts-element' );
?>"
                    <?php 
checked( $fonts === 'google-fonts' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Google fonts', 'bulletinwp' );
?></span>
            </label>
        </div>
        </div>

        <?php 
?>
    </div>

</div>
