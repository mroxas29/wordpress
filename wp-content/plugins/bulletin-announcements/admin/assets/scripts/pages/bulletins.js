import axios from 'axios';
import qs from 'qs';
import * as constants from '../util/constants';
import helpers from '../util/helpers';

const bulletins = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const bulletinsForm = bulletinwpAdmin.find('form.bulletins-form');
    if (bulletinsForm.length) {
      const page = helpers.getParameterByName('page');
      const action = helpers.getParameterByName('action');
      const _wpnonce = helpers.getParameterByName('_wpnonce');
      let checkboxWrapper = bulletinsForm.find('.checkbox-wrapper');

      if (
        page &&
        page === `${window.BULLETINWP['pluginSlug']}-options` &&
        action &&
        _wpnonce
      ) {
        const referrer = bulletinsForm.find('input[name="referrer"]');

        if (referrer.length) {
          window.location.replace(referrer.val());
        }
      }

      if (checkboxWrapper.length) {
        checkboxWrapper.each(function() {
          let thisCheckboxWrapper = $(this);

          thisCheckboxWrapper.find('input[type="checkbox"]').on('change', function(e) {
            e.preventDefault();

            let thisCheckbox = $(this);
            let bulletinID = thisCheckboxWrapper.data('bulletin-id');
            let statusAction = thisCheckboxWrapper.data('status-action');
            let titleStatus = bulletinwpAdmin.find(`.title-status-${bulletinID}`);

            thisCheckbox.attr('disabled', true);

            let data = {
              'action': constants.ACTION_UPDATE_BULLETIN_STATUS,
              'ajaxNonce': window.BULLETINWP['ajaxNonce'],
              'bulletinID': bulletinID,
              'statusAction': statusAction,
            };

            axios.post(window.BULLETINWP['ajaxUrl'], qs.stringify(data)).then((axiosResponse) => {
              if (200 === axiosResponse.status) {
                let response = axiosResponse.data;

                if (response.success) {
                  thisCheckbox.prop('disabled', false);

                  if (statusAction === 'activate') {
                    thisCheckboxWrapper.data('status-action', 'deactivate');
                  } else if (statusAction === 'deactivate') {
                    thisCheckboxWrapper.data('status-action', 'activate');
                  }

                  if (thisCheckbox.is(':checked')) {
                    // Remove Inactive label on the title
                    titleStatus.text('');
                  } else {
                    // Add Inactive label on the title
                    titleStatus.text(`- ${window.BULLETINWP['translations']['inactive']}`);
                  }
                }
              }
            }).catch((error) => {
              throw new Error(error);
            });
          });
        });
      }
    }
  });
};

export default bulletins;
