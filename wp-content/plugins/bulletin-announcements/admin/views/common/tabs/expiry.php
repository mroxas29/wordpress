<?php

defined( 'ABSPATH' ) or exit;
// Visible but disabled
isset( $add_countdown ) or $add_countdown = false;
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
?>

<!-- TAB - Expiry -->
<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-expiry-tab' );
?>" class="tab-pane">
    <div class="flex items-center mb-8 md:mb-12">
        <div class="heading-icon mr-4">
            <img src="<?php 
echo esc_url( $images_dir . '/tab-icon/message.svg' );
?>" alt="">
        </div>

        <div class="tab-heading">
            <?php 
esc_html_e( 'Expiry', 'bulletinwp' );
?>
        </div>
    </div>

    <div class="heading flex items-center">
        <?php 
esc_html_e( 'Expire bulletin', 'bulletinwp' );
?>

        <?php 
?>
        <div class="pro-pill">PRO</div>
        <?php 
?>
    </div>

    <hr class="my-4">

    <div class="checkbox-wrapper toggle-switch add-countdown-data-label <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>"
            data-checked-label="<?php 
echo esc_attr( esc_html__( 'Yes', 'bulletinwp' ) );
?>"
            data-unchecked-label="<?php 
echo esc_attr( esc_html__( 'No', 'bulletinwp' ) );
?>"
            data-hide-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-countdown-element' );
?>"
    >
        <input type="checkbox" name="addCountdown" <?php 
checked( $add_countdown );
?> />
        <span class="label add-countdown-label"><?php 
echo esc_html( ( $add_countdown ? esc_html__( 'Yes', 'bulletinwp' ) : esc_html__( 'No', 'bulletinwp' ) ) );
?></span>
    </div>

    <?php 
?>
</div>
