import axios from 'axios';
import qs from 'qs';
import * as constants from '../util/constants';

const settings = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const settingsForm = bulletinwpAdmin.find('form.settings-form');
    if (settingsForm.length) {
      settingsForm.on('submit', function(e) {
        e.preventDefault();

        const thisSettingsForm = $(this);
        const requiredFields = thisSettingsForm.find('.form-field.is-required');
        const submitButton = settingsForm.find('button[type="submit"]');
        const defaultLabel = submitButton.data('default-label');
        const loadingLabel = submitButton.data('loading-label');
        const formMessage = settingsForm.find('.form-message');
        const formFieldNotices = thisSettingsForm.find('.form-field-notice');

        requiredFields.removeClass('form-field-error');
        formFieldNotices.remove();
        submitButton.attr('disabled', true);
        submitButton.text(loadingLabel);
        formMessage.hide();
        formMessage.html('');
        formMessage.removeClass('has-error');

        let hasError = false;

        if (requiredFields.length) {
          requiredFields.each(function() {
            const thisRequiredField = $(this);
            const formInput = thisRequiredField.find('.form-input');
            if (thisRequiredField.is(':visible') && (formInput.val() === '' || formInput.val() === null || formInput.val().length === 0)) {
              hasError = true;

              thisRequiredField.addClass('form-field-error');
              thisRequiredField.append(`<div class="form-field-notice form-field-error-message">${window.BULLETINWP['translations']['thisFieldIsRequired']}</div>`);
            }
          });
        }

        if (hasError) {
          submitButton.prop('disabled', false);
          submitButton.text(defaultLabel);
          formMessage.addClass('has-error');
          formMessage.html(`${window.BULLETINWP['translations']['validationFailed']} ${window.BULLETINWP['translations']['pleaseCheckRequiredFields']}`);
          formMessage.show();

          return false;
        }

        // Form data
        let formData = thisSettingsForm.serialize();

        // Include unchecked checkboxes to form data
        let uncheckedCheckboxesData = '';
        const uncheckedCheckboxes = settingsForm.find('input[type=checkbox]:not(:checked)');
        if (uncheckedCheckboxes.length) {
          uncheckedCheckboxes.each(function() {
            const _this = $(this);
            const name = _this.attr('name');

            if (name) {
              uncheckedCheckboxesData += `&${name}=off`;
            }
          });
        }
        formData += uncheckedCheckboxesData;

        const data = {
          'action': constants.ACTION_UPDATE_SETTINGS,
          'ajaxNonce': window.BULLETINWP['ajaxNonce'],
          'formData': formData,
        };

        axios.post(window.BULLETINWP['ajaxUrl'], qs.stringify(data)).then((axiosResponse) => {
          if (200 === axiosResponse.status) {
            const response = axiosResponse.data;

            if (response.success) {
              const message = response.data['message'];

              submitButton.prop('disabled', false);
              submitButton.text(defaultLabel);
              formMessage.show();
              formMessage.html(message);
            }
          }
        }).catch((error) => {
          throw new Error(error);
        });
      });
    }
  });
};

export default settings;
