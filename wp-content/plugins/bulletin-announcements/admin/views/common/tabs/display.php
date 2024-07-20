<?php

defined( 'ABSPATH' ) or exit;
// settings values
$site_has_fixed_header = BULLETINWP::instance()->sql->get_option( 'site_has_fixed_header' );
// Default values
isset( $placement ) or $placement = 'top';
isset( $header_banner_style ) or $header_banner_style = 'above-header';
isset( $header_banner_scroll ) or $header_banner_scroll = 'static';
isset( $content_max_width ) or $content_max_width = '';
isset( $text_alignment ) or $text_alignment = 'center';
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
?>

<!-- TAB - Display -->
<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-display-tab' );
?>" class="tab-pane">
    <div class="flex items-center mb-8 md:mb-12">
        <div class="heading-icon mr-4">
        <img src="<?php 
echo esc_url( $images_dir . '/tab-icon/message.svg' );
?>" alt="">
        </div>

        <div class="tab-heading">
        <?php 
esc_html_e( 'Display options', 'bulletinwp' );
?>
        </div>
    </div>

    <div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-display-header-top-option' );
?>"
            class="mt-4 "
            style="display: <?php 
echo esc_attr( ( $placement === 'top' ? 'block' : 'none' ) );
?>"
    >

        <div class="heading"><?php 
esc_html_e( 'Header banner display', 'bulletinwp' );
?></div>

        <hr class="my-4">

        <div class="radio-group-wrapper flex">
        <div class="mr-4">
            <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-header-banner-above' );
?>"
                    type="radio"
                    name="headerBannerStyle"
                    value="above-header"
                    <?php 
checked( $header_banner_style === 'above-header' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Above header', 'bulletinwp' );
?></span>
            </label>
        </div>

        <div>
            <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-header-banner-below' );
?>"
                    type="radio"
                    name="headerBannerStyle"
                    value="below-header"
                    <?php 
checked( $header_banner_style === 'below-header' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Below header', 'bulletinwp' );
?></span>
            </label>
        </div>
        </div>
    </div>

    <div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-display-header-top-scroll-type' );
?>"
        class="mt-8"
        style="display: <?php 
echo esc_attr( ( $placement === 'top' ? 'block' : 'none' ) );
?>"
    >

      <div class="heading mb-2"><?php 
esc_html_e( 'Header banner scroll type', 'bulletinwp' );
?></div>

      <div class="radio-group-wrapper flex">
        <div class="mr-4">
          <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-header-banner-scroll-static' );
?>"
                    type="radio"
                    name="headerBannerScroll"
                    value="static"
                    <?php 
checked( $header_banner_scroll === 'static' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Static', 'bulletinwp' );
?></span>
          </label>
        </div>

        <div>
          <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-header-banner-scroll-fixed' );
?>"
                    type="radio"
                    name="headerBannerScroll"
                    value="fixed"
                    <?php 
checked( $header_banner_scroll === 'fixed' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Sticky', 'bulletinwp' );
?></span>
          </label>
        </div>
      </div>
    </div>

    <?php 
?>

    <div class="mt-8">
        <div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-default-placement-note' );
?>"
            style="display: <?php 
echo esc_attr( ( $placement !== 'corner' ? 'block' : 'none' ) );
?>">
        <span class="heading mr-2"><?php 
esc_html_e( 'Content max-width', 'bulletinwp' );
?></span>
        <span class="text-xs"><?php 
esc_html_e( '(in px, leave blank for 100% width)', 'bulletinwp' );
?></span>
        </div>

        <?php 
?>

        <hr class="my-4">

        <div>
        <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-content-max-width' );
?>"
                type="number"
                name="contentMaxWidth"
                value="<?php 
echo esc_attr( $content_max_width );
?>"
                placeholder=""
        />
        </div>
    </div>

    <div class="mt-8">
        <div class="heading mb-2"><?php 
esc_html_e( 'Text alignment', 'bulletinwp' );
?></div>

        <hr class="my-4">

        <div class="flex">
        <div class="mr-4">
            <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-text-alignment-center' );
?>"
                    type="radio"
                    name="textAlignment"
                    value="center"
                    <?php 
checked( $text_alignment === 'center' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Center', 'bulletinwp' );
?></span>
            </label>
        </div>

        <div class="mr-4">
            <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-text-alignment-left' );
?>"
                    type="radio"
                    name="textAlignment"
                    value="left"
                    <?php 
checked( $text_alignment === 'left' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Left', 'bulletinwp' );
?></span>
            </label>
        </div>

        <div>
            <label class="radio-wrapper">
            <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-text-alignment-right' );
?>"
                    type="radio"
                    name="textAlignment"
                    value="right"
                    <?php 
checked( $text_alignment === 'right' );
?>
            />
            <span class="thumb"></span>
            <span><?php 
esc_html_e( 'Right', 'bulletinwp' );
?></span>
            </label>
        </div>
        </div>
    </div>
</div>
