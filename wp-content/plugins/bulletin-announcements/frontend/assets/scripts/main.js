// FEATURES
import markdown from './features/markdown';
import helpers from './util/helpers';

const main = () => {
  jQuery(document).ready(function ($) {

    const bulletinWPContainer = $(`#${window.BULLETINWP['pluginSlug']}-generator`);
    if (bulletinWPContainer) {
      const bulletinWP = bulletinWPContainer.find(`.${window.BULLETINWP['pluginSlug']}-bulletins`);

      bulletinWP.each(function() {
        const _this = $(this);

        if (_this.hasClass(`${window.BULLETINWP['pluginSlug']}-placement-top`)) {
          const headerBannerStyle = _this.data('header-banner-style');
          const headerSelector = _this.data('fixed-header-selector') ? _this.data('fixed-header-selector') : 'header, .header, .nav';
          const $headerSelector = $(headerSelector);

          if ($headerSelector.length > 0) {
            switch (headerBannerStyle) {
              case 'above-header':
                $headerSelector.first().before(_this);
                break;
              case 'below-header':
                $headerSelector.first().after(_this);
                break;
              default:
                $('body').prepend(_this);
            }
          } else {
            // eslint-disable-next-line no-console
            console.warn(`[${window.BULLETINWP['pluginSlug']}: WARNING] The selector {${_this.data('fixed-header-selector')}} doesn't seem to exist on this page.-- setting will default to {header, .header, .nav}`);

            // fallback to common header selectors
            if ( $('header, .header, .nav').length > 0 ) {
              $('header, .header, .nav').first().before(_this);
            } else {
              $('body').prepend(_this);
            }
          }
        } else {
          $('body').prepend(_this);
        }
      });
    }

    const bulletinwpBulletins = $(`.${window.BULLETINWP['pluginSlug']}-bulletins`);
    if (bulletinwpBulletins.length) {
      // FEATURES
      // Markdown
      markdown(bulletinwpBulletins);

      bulletinwpBulletins.each(function() {
        const _this = $(this);
        const domElement = _this.get(0);
        const siteHasFixedHeader = _this.data('site-has-fixed-header');
        const headerBannerStyle = _this.data('header-banner-style');

        // Check dismiss cookie
        const bulletinItem = _this.find(`.${window.BULLETINWP['pluginSlug']}-bulletin-item`);
        const bulletinItemID = bulletinItem.data('id');
        const cookieExpiryName = `${window.BULLETINWP['pluginSlug']}-dismiss-expiry[${bulletinItemID}]`;

        helpers.docLocalStorage.checkExpiryItem(cookieExpiryName);

        // If dismissed don't adjust position
        if (helpers.docLocalStorage.getItem(cookieExpiryName)) {
          return;
        }

        if (!_this.hasClass(`${window.BULLETINWP['pluginSlug']}-init`)) {
          _this.addClass(`${window.BULLETINWP['pluginSlug']}-init`);
        }

        // Header Banner Scroll -- fixed
        if ( _this.hasClass(`${window.BULLETINWP['pluginSlug']}-placement-top`)) {
          const headerBannerScroll = _this.data('header-banner-scroll');

          const hasAdminBar = $('body').hasClass('admin-bar');
          let adminBarHeight = 0;

          if ($(window).width() >= 783) {
            adminBarHeight = hasAdminBar ? 32 : 0;
          }

          if (headerBannerScroll === 'fixed') {
            domElement.style.top = adminBarHeight + 'px';

            if (siteHasFixedHeader) {
              const fixedHeaderSelector = _this.data('fixed-header-selector') ? _this.data('fixed-header-selector') : 'header, .header, .nav';
              const selectedElement = $(fixedHeaderSelector).first();
              const selectedElementDOM = selectedElement.get(0);

              // Get position type of header selector -- determine if sticky or fixed
              const selectedElementDOMStylePosition = window.getComputedStyle(selectedElementDOM).position;
              if (selectedElementDOMStylePosition === 'sticky' || selectedElementDOMStylePosition === 'fixed') {
                domElement.style.position = selectedElementDOMStylePosition;
              }

              // Set top position if below or above selector header
              if (headerBannerStyle === 'below-header') {
                const topPosition = selectedElement.outerHeight() + adminBarHeight;
                domElement.style.top = topPosition + 'px';
              } else {
                const computedTop = parseInt(window.getComputedStyle(selectedElementDOM).top) ? parseInt(window.getComputedStyle(selectedElementDOM).top) : 0;
                let newTop = _this.outerHeight() + computedTop;

                // Edge case: sticky has no defined top position
                if (computedTop === 0) {
                  newTop += adminBarHeight;
                }

                selectedElementDOM.style.top = newTop + 'px';
              }
            }
          } else {
            /**
             * WARNING: adds margin top if banner is not fixed -- may break some sites
             */
            if (siteHasFixedHeader) {
              const fixedHeaderSelector = _this.data('fixed-header-selector') ? _this.data('fixed-header-selector') : 'header, .header, .nav';
              const selectedElement = $(fixedHeaderSelector).first();
              const selectedElementDOM = selectedElement.get(0);

              // Only apply to `position: fixed` as `sticky` has kind off a placeholder height
              if (window.getComputedStyle(selectedElementDOM).position === 'fixed') {
                const topMargin = selectedElement.outerHeight();

                domElement.style.marginTop = topMargin + 'px';
              }
            }
          }
        }

        // Sticky footer and float bottom
        if (
          _this.hasClass(`${window.BULLETINWP['pluginSlug']}-placement-sticky-footer`) ||
          _this.hasClass(`${window.BULLETINWP['pluginSlug']}-placement-float-bottom`)
        ) {
          $(window).scroll(function() {
            const totalHeight = $(window).scrollTop() + $(window).height() + _this.height();

            if (totalHeight >= $(document).height()) {
              _this.fadeOut('300');
            } else {
              _this.fadeIn('300');
            }
          });
        }
      });
    }
  });
};

export default main;
