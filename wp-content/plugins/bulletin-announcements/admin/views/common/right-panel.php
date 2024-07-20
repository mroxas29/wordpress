<?php

defined( 'ABSPATH' ) or exit;
$content_arr = [[
    'icon'    => 'knowledge',
    'link'    => 'https://www.rocksolidplugins.com/docs/bulletin/',
    'content' => esc_html__( 'View plugin docs & FAQs', 'bulletinwp' ),
], [
    'icon'    => 'growth-bars',
    'link'    => 'mailto:info@rocksoliddigital.com?subject=I%20have%20a%20recommendation%20to%20improve%20Bulletin',
    'content' => esc_html__( 'Suggest a feature for our future development', 'bulletinwp' ),
], [
    'icon'    => 'influencer-star',
    'link'    => 'https://wordpress.org/support/plugin/bulletin-announcements/reviews/?filter=5#postform',
    'content' => esc_html__( 'Like this plugin? Please give us a 5 star review!', 'bulletinwp' ),
]];
// Images url
$images_url = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images/';
?>

<div class="right-content-panel-wrapper">
  <p class="text-base font-bold mb-5"><?php 
esc_html_e( 'Explore more from Bulletin', 'bulletinwp' );
?></p>

  <?php 
foreach ( $content_arr as $key => $content ) {
    ?>
    <?php 
    $icon_file_url = $images_url . $content['icon'] . '.svg';
    ?>

    <a href="<?php 
    echo esc_url( $content['link'] );
    ?>" target="_blank" class="btn-text">
      <div class="flex flex-row mb-8 items-center">
        <div class="mr-4">
          <img src="<?php 
    echo esc_url( $icon_file_url );
    ?>" alt="">
        </div>

        <div>
          <p class="text-sm font-medium"><?php 
    echo wp_kses_post( $content['content'] );
    ?></p>
        </div>
      </div>
    </a>

  <?php 
}
?>

  <!-- Bulletin Discount CTA -->
  <?php 
?>
  <div class="box-container py-4">
    <div class="flex items-center">
      <div class="ml-4 mr-2">
        <p class="text-blue-100 text-2lg font-bold mb-4">Unlock all features</p>
        <p class="text-sm">Use code <span class="promo">rocks</span> to <br><strong>get 10%</strong> off on all plans!</p>
      </div>

      <div class="shrink-0" style="width: 85px;">
        <img src="<?php 
echo esc_url( $images_url . 'megaphone.svg' );
?>" alt="">
      </div>
    </div>

    <div class="px-4 mt-6">
      <a href="<?php 
echo esc_url( bulletinwp_fs()->pricing_url() );
?>" class="btn-round w-full">
        <img class="mr-4" src="<?php 
echo esc_url( $images_url . 'ticket.svg' );
?>" alt="">
        Buy now
      </a>
    </div>
  </div>
  <?php 
?>

  <!-- Easy Popups CTA -->
  <?php 
?>
  <div class="box-container dismiss-container relative py-4 mt-6" style="display: none">
    <div class="dismiss-button" data-dismiss-cookie="easypopups_cta"></div>

    <div class="flex items-center">
      <div class="ml-4 mr-2">
        <p class="text-blue-100 text-lg font-bold mb-4">Try Easy Popups</p>
        <p class="text-sm">Our Popup companion plugin. Get it for free on <a target="_blank" href="https://wordpress.org/plugins/easy-popups/">Wordpress.org</a></p>
      </div>

      <div class="shrink-0 mr-4" style="width: 85px;">
        <img src="<?php 
echo esc_url( $images_url . 'illustration.png' );
?>" alt="">
      </div>
    </div>

  </div>
  <?php 
?>
</div>
