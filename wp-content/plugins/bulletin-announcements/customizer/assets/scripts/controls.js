import axios from 'axios';
import qs from 'qs';
import * as constants from './util/constants';

jQuery(document).ready(function ($) {
  const bulletinIDControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-bulletin-id-control`);

  if (bulletinIDControl.length) {
    const contentControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-content-control`);
    const mobileContentControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-mobile-content-control`);
    const backgroundColorControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-background-color-control`);
    const fontColorControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-font-color-control`);
    const placementControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-control`);
    let placementCornerOptionsControl = '';
    const contentMaxWidthControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-content-max-width-control`);
    const textAlignmentControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-text-alignment-control`);
    const fontSizeControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-font-size-control`);
    const fontSizeMobileControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-font-size-mobile-control`);
    const bulletinIDControlSelect = bulletinIDControl.find(`#_customize-input-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-bulletin-id-control`);
    const contentControlTextarea = contentControl.find(`#_customize-input-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-content-control`);
    const mobileContentControlTextarea = mobileContentControl.find(`#_customize-input-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-mobile-content-control`);
    const backgroundColorControlButton = backgroundColorControl.find('button.wp-color-result');
    const fontColorControlButton = fontColorControl.find('button.wp-color-result');
    const placementControlRadios = placementControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-control"]`);
    let placementCornerControlRadios = '';
    const contentMaxWidthControlNumber = contentMaxWidthControl.find(`#_customize-input-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-content-max-width-control`);
    const contentMaxWidthControlLabel = contentMaxWidthControl.find('.customize-control-title');
    const textAlignmentControlRadios = textAlignmentControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-text-alignment-control"]`);
    const fontSizeControlNumber = fontSizeControl.find(`#_customize-input-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-font-size-control`);
    const fontSizeMobileControlNumber = fontSizeMobileControl.find(`#_customize-input-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-font-size-mobile-control`);
    const backgroundColorControlText = backgroundColorControl.find('input.wp-color-picker');
    const fontColorControlText = fontColorControl.find('input.wp-color-picker');

    if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
      placementCornerOptionsControl = $(`#customize-control-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-corner-options-control`);
      placementCornerControlRadios = placementCornerOptionsControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-corner-options-control"]`);
    }

    const showElements = function() {
      // Show elements
      contentControl.show();
      mobileContentControl.show();
      backgroundColorControl.show();
      fontColorControl.show();
      placementControl.show();
      contentMaxWidthControl.show();
      textAlignmentControl.show();
      fontSizeControl.show();
      fontSizeMobileControl.show();

      if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
        placementCornerOptionsControl.show();
      }
    };

    const hideElements = function() {
      // Hide elements
      contentControl.hide();
      mobileContentControl.hide();
      backgroundColorControl.hide();
      fontColorControl.hide();
      placementControl.hide();
      contentMaxWidthControl.hide();
      textAlignmentControl.hide();
      fontSizeControl.hide();
      fontSizeMobileControl.hide();

      if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
        placementCornerOptionsControl.hide();
      }
    };

    const enableElements = function() {
      // Enable elements
      bulletinIDControlSelect.prop('disabled', false);
      contentControlTextarea.prop('disabled', false);
      mobileContentControlTextarea.prop('disabled', false);
      backgroundColorControlButton.prop('disabled', false);
      fontColorControlButton.prop('disabled', false);
      placementControlRadios.prop('disabled', false);
      contentMaxWidthControlNumber.prop('disabled', false);
      textAlignmentControlRadios.prop('disabled', false);
      fontSizeControlNumber.prop('disabled', false);
      fontSizeMobileControlNumber.prop('disabled', false);

      if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
        if (placementControl.find('[value="corner"]').is(':checked')) {
          placementCornerControlRadios.prop('disabled', false);
          contentMaxWidthControlLabel.text('Element max-width (in px, leave blank for max-width of 300px)');
        } else {
          placementCornerControlRadios.prop('disabled', true);
          contentMaxWidthControlLabel.text('Content max-width (in px, leave blank for 100% width)');
        }
      }
    };

    const disableElements = function() {
      // Disable elements
      bulletinIDControlSelect.prop('disabled', true);
      contentControlTextarea.prop('disabled', true);
      mobileContentControlTextarea.prop('disabled', true);
      backgroundColorControlButton.prop('disabled', true);
      fontColorControlButton.prop('disabled', true);
      placementControlRadios.prop('disabled', true);
      contentMaxWidthControlNumber.prop('disabled', true);
      textAlignmentControlRadios.prop('disabled', true);
      fontSizeControlNumber.prop('disabled', true);
      fontSizeMobileControlNumber.prop('disabled', true);

      if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
        placementCornerControlRadios.prop('disabled', true);
      }
    };

    if (bulletinIDControlSelect.val() === '') {
      hideElements();
      enableElements();
    }

    bulletinIDControlSelect.on('change', function() {
      const bulletinID = bulletinIDControlSelect.val();

      if (bulletinID.length > 0) {
        showElements();
        disableElements();

        let data = {
          'action': constants.ACTION_GET_BULLETIN_DATA,
          'bulletinID': bulletinID,
        };

        axios.post(window.BULLETINWP_CUSTOMIZER_CONTROLS['ajaxUrl'], qs.stringify(data)).then((axiosResponse) => {
          if (200 === axiosResponse.status) {
            const response = axiosResponse.data;

            if (response.success) {
              const data = response.data['data'];
              const content = data['content'];
              const mobileContent = data['mobile_content'];
              const backgroundColor = data['background_color'];
              const fontColor = data['font_color'];
              const placement = data['placement'];
              const contentMaxWidth = data['content_max_width'];
              const textAlignment = data['text_alignment'];
              const fontSize = data['font_size'];
              const fontSizeMobile = data['font_size_mobile'];

              contentControlTextarea.val(content).trigger('change');
              mobileContentControlTextarea.val(mobileContent).trigger('change');
              backgroundColorControlText.val(backgroundColor).trigger('change');
              fontColorControlText.val(fontColor).trigger('change');
              placementControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-control"][value="${placement}"]`).prop('checked', true).trigger('change');
              contentMaxWidthControlNumber.val(contentMaxWidth).trigger('change');
              textAlignmentControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-text-alignment-control"][value="${textAlignment}"]`).prop('checked', true).trigger('change');
              fontSizeControlNumber.val(fontSize).trigger('change');
              fontSizeMobileControlNumber.val(fontSizeMobile).trigger('change');

              if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
                const placement_corner_options = data['placement_corner_options'];

                placementCornerOptionsControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-corner-options-control"][value="${placement_corner_options}"]`).prop('checked', true);
              }

              enableElements();
            }
          }
        });
      } else {
        hideElements();
        enableElements();

        contentControlTextarea.val('').trigger('change');
        mobileContentControlTextarea.val('').trigger('change');
        // backgroundColorControlText.val('').trigger('change');
        // fontColorControlText.val('').trigger('change');
        placementControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-control"][value="top"]`).prop('checked', true).trigger('change');
        contentMaxWidthControlNumber.val('').trigger('change');
        textAlignmentControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-text-alignment-control"][value="center"]`).prop('checked', true).trigger('change');
        fontSizeControlNumber.val('').trigger('change');
        fontSizeMobileControlNumber.val('').trigger('change');

        if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
          placementCornerOptionsControl.find(`input[name="_customize-radio-${window.BULLETINWP_CUSTOMIZER_CONTROLS['pluginSlug']}-placement-control"][value="top-left"]`).prop('checked', true);
        }
      }
    });

    if (window.BULLETINWP_CUSTOMIZER_CONTROLS['isPremium']) {
      placementControl.on('change', function() {
        if (placementControl.find('[value="corner"]').is(':checked')) {
          placementCornerControlRadios.prop('disabled', false);
          contentMaxWidthControlLabel.text('Element max-width (in px, leave blank for max-width of 300px)');
        } else {
          placementCornerControlRadios.prop('disabled', true);
          contentMaxWidthControlLabel.text('Content max-width (in px, leave blank for 100% width. If you\'re using Bootstrap, try adding 1140 here.)');
        }
      });
    }
  }
});
