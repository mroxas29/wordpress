<?php

defined( 'ABSPATH' ) or exit;
// Default values
isset( $id ) or $id = '';
// Visible but disabled
isset( $additional_css ) or $additional_css = '';
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
?>

<!-- TAB - Advanced -->
<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-advanced-tab' );
?>" class="tab-pane">
    <div class="flex items-center mb-8 md:mb-12">
        <div class="heading-icon mr-4">
        <img src="<?php 
echo esc_url( $images_dir . '/tab-icon/message.svg' );
?>" alt="">
        </div>

        <div class="tab-heading">
        <?php 
esc_html_e( 'Advanced', 'bulletinwp' );
?>
        </div>
    </div>

    <div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-additional-css-element' );
?>">
        <div class="heading flex items-center">
            <?php 
esc_html_e( 'Additional CSS to render with this bulletin', 'bulletinwp' );
?>

            <?php 
?>
                <div class="pro-pill">PRO</div>
            <?php 
?>
            </div>

            <hr class="my-4">

            <div class="<?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>">
            <textarea id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-additional-css' );
?>"
                        class="form-input textarea-input w-full"
                        name="additionalCss"
                        placeholder=""
            ><?php 
echo esc_textarea( $additional_css );
?></textarea>

            <div class="text-sm">
                <?php 
echo esc_html( 'i.e. #' . BULLETINWP_PLUGIN_SLUG . '-bulletin-item-' . (( !empty( $id ) ? $id : '1' )) . ' { ... }' );
?>
                <br />
                <?php 
echo esc_html( ( is_multisite() && is_main_site() ? 'for subsites: #' . BULLETINWP_PLUGIN_SLUG . '-bulletin-item-global-' . (( !empty( $id ) ? $id : '1' )) . ' { ... }' : '' ) );
?>
            </div>
        </div>
    </div>
</div>
