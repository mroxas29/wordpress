<?php

defined( 'ABSPATH' ) or exit;

// Images directory
$images_dir = plugin_dir_url( BULLETINWP__FILE__ ) . 'admin/images';

?>

<div id="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin' ) ?>">
  <div class="<?php echo esc_attr( BULLETINWP_PLUGIN_SLUG . '-admin-welcome wrap' ) ?>">

    <h2 class="hidden">
      <!-- notifications go here -->
    </h2>

    <div class="container mb-16">
      <!-- megaphone logo -->
      <img src="<?php echo esc_url( $images_dir . '/logo.svg' ) ?>" alt="" class="mx-auto mb-16">

      <!-- box section -->
      <div class="box-container pt-20 pb-16 mb-20">
        <div class="logo-wrapper">
          <img src="<?php echo esc_url( $images_dir . '/logo-text.svg' ) ?>" alt="logo-text">
        </div>


        <div class="mb-8">
          <h1><?php esc_html_e( 'Well, hello there!', 'bulletinwp' ) ?></h1>
        </div>

        <div class="w-1/2 mb-8">
          <?php esc_html_e( 'Congrats on activating Bulletin. You&apos;re moments away from adding incredibly easy (and powerful) announcement banners to your site!', 'bulletinwp' ) ?>
        </div>

        <a href="<?php echo esc_url( add_query_arg( [ 'page' => BULLETINWP_PLUGIN_SLUG . '-options-add-new' ], 'admin.php' ) ) ?>" class="btn">
          <span><?php esc_html_e( 'Add my first bulletin', 'bulletinwp' ) ?></span>
          <img src="<?php echo esc_url( $images_dir . '/angle.svg' ) ?>" alt="">
        </a>
      </div>

      <!-- Upgrade pro benefits -->
      <div class="mb-20">
        <div class="text-center mb-16">
          <h2><?php esc_html_e( 'Upgrade to Pro', 'bulletinwp' ) ?></h2>
        </div>

        <!-- benefit items -->
        <div class="flex flex-wrap -mx-4">

          <div class="w-1/3 px-4 mb-8">
            <div class="bullet-item">
              <h4 class="mb-2"><?php esc_html_e( 'Call to actions', 'bulletinwp' ) ?></h4>
              <div><?php esc_html_e( 'Add buttons that link to external pages or trigger custom code.', 'bulletinwp' ) ?></div>
            </div>
          </div>

          <div class="w-1/3 px-4 mb-8">
            <div class="bullet-item">
              <h4 class="mb-2"><?php esc_html_e( 'Add a countdown', 'bulletinwp' ) ?></h4>
              <div><?php esc_html_e( 'Counting down to something or trying to install a bit of FOMO? We got you covered.', 'bulletinwp' ) ?></div>
            </div>
          </div>

          <div class="w-1/3 px-4 mb-8">
            <div class="bullet-item">
              <h4 class="mb-2"><?php esc_html_e( 'Custom icons and fonts', 'bulletinwp' ) ?></h4>
              <div><?php esc_html_e( 'Make it your own using cool icons and stylish google fonts.', 'bulletinwp' ) ?></div>
            </div>
          </div>

          <div class="w-1/3 px-4 mb-8">
            <div class="bullet-item">
              <h4 class="mb-2"><?php esc_html_e( 'Add multiple messages in one', 'bulletinwp' ) ?></h4>
              <div><?php esc_html_e( 'Rotate through or let them run in marquee style.', 'bulletinwp' ) ?></div>
            </div>
          </div>

          <div class="w-1/3 px-4 mb-8">
            <div class="bullet-item">
              <h4 class="mb-2"><?php esc_html_e( 'Advanced placement options', 'bulletinwp' ) ?></h4>
              <div><?php esc_html_e( 'Show a bulletin only on selected pages on your site. Or only for logged-in users.', 'bulletinwp' ) ?></div>
            </div>
          </div>

          <div class="w-1/3 px-4 mb-8">
            <div class="bullet-item">
              <h4 class="mb-2"><?php esc_html_e( 'WordPress Network support', 'bulletinwp' ) ?></h4>
              <div><?php esc_html_e( 'Run bulletins on all your subsites.', 'bulletinwp' ) ?></div>
            </div>
          </div>

        </div>

        <div class="text-center">
          <div class="leading-none"><?php esc_html_e( 'from', 'bulletinwp' ) ?></div>

          <div class="mb-8">
            <span class="font-playfair font-bold leading-none text-2xxl">$29</span> / <?php esc_html_e( 'year', 'bulletinwp' ) ?>
          </div>

          <div class="mb-2">
            <a href="<?php echo esc_url( bulletinwp_fs()->pricing_url() ) ?>" class="btn btn-fill">
              <span><?php esc_html_e( 'Buy now', 'bulletinwp' ) ?></span>
              <img src="<?php echo esc_url( $images_dir . '/angle-white.svg' ) ?>" alt="">
            </a>
          </div>
          <a href="https://www.rocksolidplugins.com/plugins/bulletin/?utm_source=WordPress&utm_campaign=freeplugin&utm_medium=upgrade-panel" target="_blank"><?php esc_html_e( 'Learn more', 'bulletinwp' ) ?></a>

        </div>
      </div>

      <!-- quote -->
      <div class="text-center">
        <img src="<?php echo esc_url( $images_dir . '/quote.svg' ) ?>" alt="quote" class="mx-auto mb-8">

        <blockquote class="mb-4">
          Bulletin provided a near-perfect solution. It is versatile, easy to use, and is a cost-effective way to display important content prominently, but without detracting from other content on the page. I would rate it near-perfect!
        </blockquote>

        <div>
          Dave White, Alabama broadcasters
        </div>
      </div>
    </div>
  </div>
</div>
