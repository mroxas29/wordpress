<?php

defined( 'ABSPATH' ) or exit;
// Default values
// Visible but disabled
isset( $placement_by_content ) or $placement_by_content = 'everywhere';
isset( $placement_by_user ) or $placement_by_user = 'everyone';
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
?>

<!-- TAB - Placement -->
<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-tab' );
?>" class="tab-pane">
    <div class="flex items-center mb-8 md:mb-12">
        <div class="heading-icon mr-4">
            <img src="<?php 
echo esc_url( $images_dir . '/tab-icon/message.svg' );
?>" alt="">
        </div>

        <div class="tab-heading">
            <?php 
esc_html_e( 'Placement', 'bulletinwp' );
?>
        </div>
    </div>

    <!-- Actual Pro Feat -->
    <div class="heading flex items-center">
        <?php 
esc_html_e( 'By content', 'bulletinwp' );
?>

        <?php 
?>
            <div class="pro-pill">PRO</div>
        <?php 
?>
    </div>

    <hr class="my-4">

    <div class="radio-group-wrapper flex <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>">
        <div class="mr-4">
            <label class="radio-wrapper">
                <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-by-content-everywhere' );
?>"
                        type="radio"
                        name="placementByContent"
                        value="everywhere"
                        <?php 
checked( $placement_by_content === 'everywhere' );
?>
                />
                <span class="thumb"></span>
                <span><?php 
esc_html_e( 'Show everywhere', 'bulletinwp' );
?></span>
            </label>
        </div>

        <div>
            <label class="radio-wrapper">
                <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-by-content-selected-content' );
?>"
                        type="radio"
                        name="placementByContent"
                        value="selected-content"
                        data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-placement-selected-content-include-element' );
?>, #<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-selected-content-exclude-element' );
?>"
                        <?php 
checked( $placement_by_content === 'selected-content' );
?>
                />
                <span class="thumb"></span>
                <span><?php 
esc_html_e( 'Show only on certain content', 'bulletinwp' );
?></span>
            </label>
        </div>
    </div>

    <?php 
?>

    <div class="mt-8">
        <div class="heading flex items-center">
            <?php 
esc_html_e( 'By user', 'bulletinwp' );
?>

            <?php 
?>
                <div class="pro-pill">PRO</div>
            <?php 
?>
        </div>

        <hr class="my-4">

        <div class="radio-group-wrapper flex <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>">
            <div class="mr-4">
                <label class="radio-wrapper">
                <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-by-user-everyone' );
?>"
                        type="radio"
                        name="placementByUser"
                        value="everyone"
                        <?php 
checked( $placement_by_user === 'everyone' );
?>
                />
                <span class="thumb"></span>
                <span><?php 
esc_html_e( 'Show for everyone', 'bulletinwp' );
?></span>
                </label>
            </div>

            <div class="mr-4">
                <label class="radio-wrapper">
                <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-by-user-logged-in-users' );
?>"
                        type="radio"
                        name="placementByUser"
                        value="logged-in-users"
                        <?php 
checked( $placement_by_user === 'logged-in-users' );
?>
                />
                <span class="thumb"></span>
                <span><?php 
esc_html_e( 'Only logged-in users', 'bulletinwp' );
?></span>
                </label>
            </div>

            <div class="mr-4">
                <label class="radio-wrapper">
                <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-by-user-cookie-value' );
?>"
                        type="radio"
                        name="placementByUser"
                        value="cookie-value"
                        data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-placement-user-cookie-value-element' );
?>"
                        <?php 
checked( $placement_by_user === 'cookie-value' );
?>
                />
                <span class="thumb"></span>
                <span><?php 
esc_html_e( 'Based on cookie value', 'bulletinwp' );
?></span>
                </label>
            </div>

            <div>
                <label class="radio-wrapper">
                <input id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-placement-by-user-ip-address' );
?>"
                        type="radio"
                        name="placementByUser"
                        value="ip-address"
                        data-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-placement-user-ip-address-element' );
?>"
                        <?php 
checked( $placement_by_user === 'ip-address' );
?>
                />
                <span class="thumb"></span>
                <span><?php 
esc_html_e( 'Based on IP address', 'bulletinwp' );
?></span>
                </label>
            </div>
        </div>

        <?php 
?>
    </div>

</div>
