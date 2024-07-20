<?php

defined( 'ABSPATH' ) or exit;
// Default values
isset( $content ) or $content = '';
isset( $mobile_content ) or $mobile_content = '';
// Visible but disabled
isset( $is_multiple_messages ) or $is_multiple_messages = false;
isset( $hide_fields_from_cycle ) or $hide_fields_from_cycle = false;
isset( $add_button ) or $add_button = false;
isset( $is_dismissable ) or $is_dismissable = false;
// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';
?>

<!-- TAB - Message -->
<div id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-message-tab' );
?>" class="tab-pane active">
  <div class="flex items-center mb-8 md:mb-12">
    <div class="heading-icon mr-4">
      <img src="<?php 
echo esc_url( $images_dir . '/tab-icon/message.svg' );
?>" alt="">
    </div>

    <div class="tab-heading">
      <?php 
esc_html_e( 'Message', 'bulletinwp' );
?>
    </div>
  </div>

  <div class="flex items-end justify-between">
    <div class="heading">
      <?php 
esc_html_e( 'Message', 'bulletinwp' );
?>
    </div>

    <div class="text-right modal-button-wrapper relative" data-overlay=".modal-overlay" data-id-modal="#support-markdown-modal">
      <a class="modal-button cursor-pointer"><?php 
esc_html_e( 'supports markdown, emojis & links', 'bulletinwp' );
?></a>

      <div id="support-markdown-modal" class="modal opacity-0 pointer-events-none relative">
        <div class="modal-overlay tooltip-overlay"></div>

        <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-support-markdown box-container' );
?>">
          <div class="line-indicator"></div>

          <div class="flex my-4 border-b-2">
            <div class="w-1/2 px-4">
              <div class="heading"><?php 
esc_html_e( 'Enter this', 'bulletinwp' );
?></div>
            </div>
            <div class="w-1/2 px-4">
              <div class="heading"><?php 
esc_html_e( 'To see this', 'bulletinwp' );
?></div>
            </div>
          </div>

          <div class="flex my-4">
            <div class="w-1/2 px-4">
              <p class="font-couriernew">
                **<?php 
esc_html_e( 'This is bold', 'bulletinwp' );
?>**
              </p>
            </div>
            <div class="w-1/2 px-4">
              <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-markdown-items' );
?>">
                **<?php 
esc_html_e( 'This is bold', 'bulletinwp' );
?>**
              </div>
            </div>
          </div>

          <div class="flex my-4">
            <div class="w-1/2 px-4">
              <p class="font-couriernew">
                  *<?php 
esc_html_e( 'This is italic', 'bulletinwp' );
?>*
              </p>
            </div>
            <div class="w-1/2 px-4">
              <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-markdown-items' );
?>">
                  *<?php 
esc_html_e( 'This is italic', 'bulletinwp' );
?>*
              </div>
            </div>
          </div>

          <div class="flex my-4">
            <div class="w-1/2 px-4">
              <p class="font-couriernew">
                  [<?php 
esc_html_e( 'link text', 'bulletinwp' );
?>](https://google.com)
              </p>
            </div>
            <div class="w-1/2 px-4">
              <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-markdown-items' );
?>">
                [<?php 
esc_html_e( 'link text', 'bulletinwp' );
?>](https://google.com)
              </div>
            </div>
          </div>

          <div class="flex my-4">
            <div class="w-1/2 px-4">
              <p class="font-couriernew">
                <?php 
echo esc_html( htmlspecialchars( '<a href="https://google.com" target="_blank">' ) );
?>
                <?php 
esc_html_e( 'link text', 'bulletinwp' );
?> (<?php 
esc_html_e( 'open in new tab', 'bulletinwp' );
?>)
                <?php 
echo esc_html( htmlspecialchars( '</a>' ) );
?>
              </p>
            </div>
            <div class="w-1/2 px-4">
              <div>
                <p>
                  <a href="https://google.com" target="_blank">
                    <?php 
esc_html_e( 'link text', 'bulletinwp' );
?> (<?php 
esc_html_e( 'open in new tab', 'bulletinwp' );
?>)
                  </a>
                </p>
              </div>
            </div>
          </div>

          <div class="flex my-4">
            <div class="w-1/2 px-4">
              <p class="font-couriernew">
                <?php 
esc_html_e( 'paste codes', 'bulletinwp' );
?> `<?php 
esc_html_e( 'with backticks', 'bulletinwp' );
?>`
              </p>
            </div>
            <div class="w-1/2 px-4">
              <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-markdown-item' );
?>">
                <?php 
esc_html_e( 'paste codes', 'bulletinwp' );
?> `<?php 
esc_html_e( 'with backticks', 'bulletinwp' );
?>`
              </div>
            </div>
          </div>

          <div class="flex my-4">
            <div class="w-1/2 px-4">
              <p class="font-couriernew">:grin:</p>
              <div class="text-left">
                <a href="https://gist.github.com/rxaviers/7360908" target="_blank">
                  <?php 
esc_html_e( 'view full list of emoji commands', 'bulletinwp' );
?>
                </a>
              </div>
            </div>
            <div class="w-1/2 px-4">
              <div class="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-markdown-item' );
?>">:grin:</div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <hr class="my-4">

  <div class="flex flex-wrap -mx-4">
    <div class="form-field form-field-text w-full lg:w-1/2 mb-4 lg:mb-0 px-4">
      <label class="mb-2" for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-content' );
?>">
        <?php 
esc_html_e( 'Tablet and up', 'bulletinwp' );
?>
      </label>
      <textarea id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-content' );
?>"
                class="form-input textarea-input w-full"
                type="text"
                name="content"
                placeholder=""
      ><?php 
echo esc_textarea( $content );
?></textarea>
    </div>

    <div class="form-field form-field-text w-full lg:w-1/2 mb-4 lg:mb-0 px-4">
      <label class="mb-2" for="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-mobile-content' );
?>">
        <?php 
esc_html_e( 'Mobile only (optional)', 'bulletinwp' );
?>
      </label>
      <textarea id="<?php 
echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-mobile-content' );
?>"
                class="form-input textarea-input w-full"
                type="text"
                name="mobileContent"
                placeholder=""
      ><?php 
echo esc_textarea( $mobile_content );
?></textarea>
    </div>
  </div>

  <div class="mt-8">
    <div class="heading flex items-center">
      <?php 
esc_html_e( 'Add multiple messages', 'bulletinwp' );
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
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-messages-element, #' . BULLETINWP_PLUGIN_SLUG . '-rotation-style-element' );
?>"
      >
        <input type="checkbox" name="isMultipleMessages" <?php 
checked( $is_multiple_messages );
?> />
        <span class="label"><?php 
echo esc_html( ( $is_multiple_messages ? esc_html__( 'Yes', 'bulletinwp' ) : esc_html__( 'No', 'bulletinwp' ) ) );
?></span>
      </div>

      <?php 
?>
  </div>

  <div class="mt-8">
      <div class="heading flex items-center">
        <?php 
esc_html_e( 'Add button', 'bulletinwp' );
?>
        <?php 
?>
          <div class="pro-pill">PRO</div>
        <?php 
?>
      </div>

      <hr class="my-4">

      <div class="checkbox-wrapper toggle-switch <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>"
          data-checked-label="<?php 
esc_html_e( 'Yes', 'bulletinwp' );
?>"
          data-unchecked-label="<?php 
esc_html_e( 'No', 'bulletinwp' );
?>"
          data-hide-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-button-elements' );
?>"
      >
      <input type="checkbox" name="addButton" <?php 
checked( $add_button );
?> />
      <span class="label"><?php 
echo esc_html( ( $add_button ? esc_html__( 'Yes', 'bulletinwp' ) : esc_html__( 'No', 'bulletinwp' ) ) );
?></span>
      </div>

      <?php 
?>
  </div>

  <!-- Allow user to dismiss -->
  <div class="mt-8">
      <div class="heading flex items-center">
      <?php 
esc_html_e( 'Allow user to dismiss bulletin?', 'bulletinwp' );
?>

      <?php 
?>
          <div class="pro-pill">PRO</div>
      <?php 
?>
      </div>

      <hr class="my-4">

      <div class="checkbox-wrapper toggle-switch <?php 
echo esc_attr( ( bulletinwp_fs()->is__premium_only() ? '' : 'pro-disabled' ) );
?>"
          data-checked-label="<?php 
esc_html_e( 'Yes', 'bulletinwp' );
?>"
          data-unchecked-label="<?php 
esc_html_e( 'No', 'bulletinwp' );
?>"

          data-hide-show-elements="<?php 
echo esc_attr( '#' . BULLETINWP_PLUGIN_SLUG . '-cookie-expiry-element' );
?>"
      >
      <input type="checkbox" name="isDismissable" <?php 
checked( $is_dismissable );
?> />
      <span class="label"><?php 
echo esc_html( ( $is_dismissable ? esc_html__( 'Yes', 'bulletinwp' ) : esc_html__( 'No', 'bulletinwp' ) ) );
?></span>
      </div>

      <?php 
?>
  </div>

</div>
