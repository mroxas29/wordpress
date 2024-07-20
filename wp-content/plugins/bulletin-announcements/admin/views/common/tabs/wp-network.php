<?php

defined( 'ABSPATH' ) or exit;
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
?>

<!-- TAB - WP Network -->
<?php 
if ( is_multisite() && is_main_site() ) {
    ?>
    <div id="<?php 
    echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-network-tab' );
    ?>" class="tab-pane">
        <div class="flex items-center mb-8 md:mb-12">
            <div class="heading-icon mr-4">
                <img src="<?php 
    echo esc_url( $images_dir . '/tab-icon/message.svg' );
    ?>" alt="">
            </div>

            <div class="tab-heading">
                <?php 
    esc_html_e( 'WP Network', 'bulletinwp' );
    ?>
            </div>
        </div>

        <label class="heading flex items-center" for="<?php 
    echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-apply-all-subsites' );
    ?>">
            <?php 
    esc_html_e( 'Apply to all subsites', 'bulletinwp' );
    ?>

            <?php 
    ?>
                <div class="pro-pill">PRO</div>
            <?php 
    ?>
        </label>

        <hr class="my-4">

        <div class="checkbox-wrapper toggle-switch <?php 
    echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
    ?>"
            data-checked-label="<?php 
    echo esc_attr( esc_html__( 'Yes', 'bulletinwp' ) );
    ?>"
            data-unchecked-label="<?php 
    echo esc_attr( esc_html__( 'No', 'bulletinwp' ) );
    ?>"
        >
            <input id="<?php 
    echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-apply-all-subsites' );
    ?>" type="checkbox" name="applyAllSubsites" <?php 
    checked( $apply_all_subsites );
    ?> />
            <span class="label"><?php 
    echo esc_html( ( $apply_all_subsites ? esc_html__( 'Yes', 'bulletinwp' ) : esc_html__( 'No', 'bulletinwp' ) ) );
    ?></span>
        </div>
    </div>
<?php 
}