<?php

defined( 'ABSPATH' ) or exit;

?>

<div class="<?php echo esc_attr( "{$plugin_slug}-bulletin-content-wrapper" ) ?>" style="text-align: <?php echo esc_attr( $text_align ) ?>;">
  <?php if ( ! empty( $content ) ) : ?>
    <div class="<?php echo esc_attr( "{$plugin_slug}-bulletin-content {$plugin_slug}-bulletin-content-main" ) ?>">
      <?php echo wp_kses_post( nl2br( $content ) ) ?>
    </div>
  <?php endif; ?>

  <?php if ( ! empty( $mobile_content ) ) : ?>
    <div class="<?php echo esc_attr( "{$plugin_slug}-bulletin-mobile-content {$plugin_slug}-bulletin-mobile-content-main" ) ?>">
      <?php echo wp_kses_post( nl2br( $mobile_content ) ) ?>
    </div>
  <?php endif; ?>
</div>
