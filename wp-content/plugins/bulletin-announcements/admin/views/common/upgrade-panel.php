<?php

defined( 'ABSPATH' ) or exit;

isset( $is_settings_page ) or $is_settings_page = false;

?>

<div class="flex flex-col md:flex-row mt-16">
  <?php if ( ! $is_settings_page ) : ?>
    <div style="width: 300px;" class="hidden md:block flex-shrink-0 hidden-wrapper"></div>
  <?php endif; ?>

  <div class="relative flex-grow text-center border-2 border-blue-100 p-4 md:p-12 upgrade-panel-wrapper">
    <div class="box-heading">
      <h2><?php esc_html_e( 'Upgrade to PRO', 'bulletinwp' ) ?></h2>
    </div>

    <div class="mb-12"><?php esc_html_e( 'Upgrade to get instant access to the following features', 'bulletinwp' ) ?></div>

    <div class="flex flex-wrap text-left justify-center -mx-4 mb-10 features-wrapper">
      <div class="flex flex-col px-4 features-items">
        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Schedule and Expire Bulletins', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Add rotating messages or marquees', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Add a countdown clock', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Include / exclude bulletins on certain pages', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Show bulletin for logged-in users', 'bulletinwp' ) ?></h4>
        </div>
      </div>

      <div class="flex flex-col px-4 features-items">

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Eye-popping icons', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Custom button & Actions', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Custom Google fonts', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Add advanced CSS to bulletins', 'bulletinwp' ) ?></h4>
        </div>

        <div class="bullet-item mb-4">
          <h4><?php esc_html_e( 'Wordpress Network support', 'bulletinwp' ) ?></h4>
        </div>
      </div>
    </div>

    <div class="text-center mb-8">
      <div class="leading-none"><?php esc_html_e( 'from', 'bulletinwp' ) ?></div>
      <div><span class="font-playfair font-bold leading-none text-6xl md:text-2xxl">$29</span> / <?php esc_html_e( 'year', 'bulletinwp' ) ?></div>
    </div>

    <div class="mb-4">
      <a href="<?php echo esc_url( bulletinwp_fs()->pricing_url() ) ?>"
        class="btn-fill"
      >
        <span><?php esc_html_e( 'See all pricing options', 'bulletinwp' ) ?></span>
        <img src="<?php echo esc_url( $images_dir . '/angle-white.svg' ) ?>" alt="">
      </a>
    </div>

    <a href="https://www.rocksolidplugins.com/plugins/bulletin/?utm_source=WordPress&utm_campaign=freeplugin&utm_medium=upgrade-panel" target="_blank"><?php esc_html_e( 'Learn more', 'bulletinwp' ) ?></a>
  </div>
</div>
