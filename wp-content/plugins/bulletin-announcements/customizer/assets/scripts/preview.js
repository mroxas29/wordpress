import MarkdownIt from 'markdown-it';
import { full as emoji } from 'markdown-it-emoji';

jQuery(document).ready(function ($) {
  const handlePreviewChanges = function(key, value) {
    const bulletinID = wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-bulletin-id`).get();
    const placement = wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-placement`).get();
    const generalWidth = wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-content-max-width`).get();
    const textAlignment = wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-text-alignment`).get();
    const bulletin = $(`#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-item-${bulletinID}`);
    let placementCornerOptions = '';
    let countdownTimerWrapper = '';
    let placementCornerTimer = '';

    if (window.BULLETINWP_CUSTOMIZER_PREVIEW['isPremium']) {
      placementCornerOptions = wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-placement-corner-options`).get();
      placementCornerTimer = bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-placement-corner-timer`).first();
      countdownTimerWrapper = bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-timer`).first();
    }

    if (bulletin.length) {
      if (key === 'content') {
        const md = new MarkdownIt({
          html: true,
          breaks: true,
          linkify: true,
        }).use(emoji);
        const content = value.trim();
        const markdownContent = md.render(content);

        bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-content-main`).html(markdownContent);
      } else if (key === 'mobile_content') {
        const md = new MarkdownIt({
          html: true,
          breaks: true,
          linkify: true,
        }).use(emoji);
        const content = value.trim();
        const markdownContent = md.render(content);

        bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-mobile-content-main`).html(markdownContent);
      } else if (key === 'background_color') {
        bulletin.css('background-color', value);
      } else if (key === 'font_color') {
        bulletin.css('color', value);
      } else if (key === 'placement') {
        if (value === 'corner' && window.BULLETINWP_CUSTOMIZER_PREVIEW['isPremium']) {
          bulletin.detach().appendTo(`#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletins-corner-${placementCornerOptions}`);
          bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-content-wrapper`).css('text-align', 'left');

          if (placementCornerTimer.length) {
            placementCornerTimer.css('margin-bottom', '16px');
          }

          if (countdownTimerWrapper.length) {
            countdownTimerWrapper.detach().appendTo(`#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-timer-corner-wrapper .${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-placement-corner-timer`);
          }

          if (generalWidth.length > 0) {
            bulletin.css('max-width', `${generalWidth}px`);
          } else {
            bulletin.css('max-width', '300px');
          }
        } else {
          bulletin.detach().appendTo(`#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletins-${value}`);
          bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-content-wrapper`).css('text-align', textAlignment);

          if (placementCornerTimer.length) {
            placementCornerTimer.css('margin-bottom', '0px');
          }

          if (countdownTimerWrapper.length) {
            countdownTimerWrapper.detach().appendTo(`#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-timer-default-wrapper`);
          }

          if (value === 'float-bottom') {
            if (generalWidth.length > 0) {
              bulletin.css('max-width', `${generalWidth}px`);
            } else {
              bulletin.css('max-width', 'none');
            }
          } else {
            bulletin.css('max-width', 'none');
          }
        }
      } else if (key === 'placement_corner_options' && window.BULLETINWP_CUSTOMIZER_PREVIEW['isPremium']) {
        bulletin.detach().appendTo(`#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletins-corner-${value}`);
      } else if (key === 'content_max_width') {
        if (placement === 'float-bottom' || placement === 'corner') {
          if (value.length > 0) {
            bulletin.css('max-width', `${value}px`);
          } else if (placement === 'corner' && value.length === 0) {
            bulletin.css('max-width', '300px');
          } else {
            bulletin.css('max-width', 'none');
          }
        } else if (value.length > 0) {
          bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-main-container`).css('max-width', `${value}px`);
          bulletin.css('max-width', 'none');
        } else {
          bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-main-container`).css('max-width', 'none');
          bulletin.css('max-width', 'none');
        }
      } else if (key === 'text_alignment') {
        bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-content-wrapper`).css('text-align', value);
        bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-center`).removeClass(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-center`).addClass(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-${value}`);
        bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-left`).removeClass(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-left`).addClass(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-${value}`);
        bulletin.find(`.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-right`).removeClass(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-right`).addClass(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-countdown-alignment-${value}`);
      } else if (key === 'font_size') {
        const fontSizeStyle = $(`style.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-customizer-preview-font-size-style`);

        if (fontSizeStyle.length) {
          fontSizeStyle.remove();
        }

        if (value.length > 0) {
          $(`<style class="${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-customizer-preview-font-size-style">#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-item-${bulletinID} {font-size: ${value}px;}</style>`).insertBefore(bulletin);
        }
      } else if (key === 'font_size_mobile') {
        const fontSizeMobileStyle = $(`style.${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-customizer-preview-font-size-mobile-style`);

        if (fontSizeMobileStyle.length) {
          fontSizeMobileStyle.remove();
        }

        if (value.length > 0) {
          $(`<style class="${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-customizer-preview-font-size-mobile-style">@media (max-width: 767px) {#${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-bulletin-item-${bulletinID} {font-size: ${value}px;}}</style>`).insertBefore(bulletin);
        }
      }
    }
  };

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-content`, function(content) {
    content.bind(function(value) {
      handlePreviewChanges('content', value);
    });
  });

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-mobile-content`, function(mobileContent) {
    mobileContent.bind(function(value) {
      handlePreviewChanges('mobile_content', value);
    });
  });

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-background-color`, function(backgroundColor) {
    backgroundColor.bind(function(value) {
      handlePreviewChanges('background_color', value);
    });
  });

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-font-color`, function(fontColor) {
    fontColor.bind(function(value) {
      handlePreviewChanges('font_color', value);
    });
  });

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-placement`, function(placement) {
    placement.bind(function(value) {
      handlePreviewChanges('placement', value);
    });
  });

  if (window.BULLETINWP_CUSTOMIZER_PREVIEW['isPremium']) {
    wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-placement-corner-options`, function(placementCornerOptions) {
      placementCornerOptions.bind(function(value) {
        handlePreviewChanges('placement_corner_options', value);
      });
    });
  }

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-content-max-width`, function(contentMaxWidth) {
    contentMaxWidth.bind(function(value) {
      handlePreviewChanges('content_max_width', value);
    });
  });

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-text-alignment`, function(textAlignment) {
    textAlignment.bind(function(value) {
      handlePreviewChanges('text_alignment', value);
    });
  });

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-font-size`, function(fontSize) {
    fontSize.bind(function(value) {
      handlePreviewChanges('font_size', value);
    });
  });

  wp.customize(`${window.BULLETINWP_CUSTOMIZER_PREVIEW['pluginSlug']}-general-section-font-size-mobile`, function(fontSizeMobile) {
    fontSizeMobile.bind(function(value) {
      handlePreviewChanges('font_size_mobile', value);
    });
  });
});
