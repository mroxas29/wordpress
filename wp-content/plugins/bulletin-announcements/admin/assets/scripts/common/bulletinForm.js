import axios from 'axios';
import qs from 'qs';
import * as constants from '../util/constants';
import helpers from '../util/helpers';

const bulletinFormFunction = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const bulletinForm = bulletinwpAdmin.find('form.bulletin-form');
    if (bulletinForm.length) {
      bulletinForm.on('submit', function(e) {
        e.preventDefault();

        const thisBulletinForm = $(this);
        const requiredFields = thisBulletinForm.find('.form-field.is-required');
        const formFieldNotices = thisBulletinForm.find('.form-field-notice');
        const submitButton = thisBulletinForm.find('button[type="submit"]');
        const checkboxWrapper = thisBulletinForm.find('.right-content .checkbox-wrapper');
        const inputIsActive = thisBulletinForm.find('input[name="isActivated"]');
        const activeSwitchLabel = thisBulletinForm.find('.active-switch-label');
        const addSchedule = thisBulletinForm.find('input[name="addSchedule"]');
        const countdownTime = new Date(thisBulletinForm.find('input[name="countdown"]').val()).getTime();
        const startScheduleTime = new Date(thisBulletinForm.find('input[name="startSchedule"]').val()).getTime();
        let buttonStatus = submitButton.data('button-status');
        let defaultLabel = submitButton.data('default-label');
        let loadingLabel = submitButton.data('loading-label');
        const formMessage = thisBulletinForm.find('.form-message');
        const tabItems = thisBulletinForm.find('.tab-item');

        requiredFields.removeClass('form-field-error');
        tabItems.removeClass('tab-error');
        formFieldNotices.remove();
        submitButton.attr('disabled', true);
        submitButton.text(loadingLabel);
        formMessage.hide();
        formMessage.html('');
        formMessage.removeClass('has-error');

        let hasError = false;

        if (buttonStatus === 'publish' && !addSchedule.is(':checked')) {
          inputIsActive.prop('checked', true);
        }

        if (addSchedule.is(':checked') && inputIsActive.is(':checked')) {
          inputIsActive.prop('disabled', false);
          inputIsActive.prop('checked', false);
          activeSwitchLabel.text(checkboxWrapper.data('unchecked-label'));
          inputIsActive.prop('disabled', true);
        }

        if (addSchedule.is(':checked')) {
          let currentDateAndTime = new Date();
          const timezoneString = window.BULLETINWP['timezoneString'];

          if (timezoneString) {
            currentDateAndTime = new Date(currentDateAndTime.toLocaleString('en-US', {timeZone: timezoneString}));
          }

          if (startScheduleTime >= countdownTime || currentDateAndTime.getTime() >= startScheduleTime) {
            submitButton.prop('disabled', false);
            submitButton.text(defaultLabel);
            formMessage.addClass('has-error');
            formMessage.html(`${window.BULLETINWP['translations']['invalidScheduleTime']}`);
            formMessage.show();

            return false;
          }
        }

        if (requiredFields.length) {
          requiredFields.each(function() {
            const thisRequiredField = $(this);
            const formInput = thisRequiredField.find('.form-input');
            const tabPaneID = thisRequiredField.closest('.tab-pane').first().attr('id');
            const tabItem = thisBulletinForm.find(`.tab-item[data-tab="#${tabPaneID}"]`);

            if (thisRequiredField.is(':visible') && formInput.val() === '' || formInput.val() === null) {
              hasError = true;
              tabItem.addClass('tab-error');
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

        // Bulletin ID
        const bulletinID = helpers.getParameterByName('bulletin');

        // Form data
        let formData = thisBulletinForm.serialize();

        // Include unchecked checkboxes to form data
        const uncheckedCheckboxes = thisBulletinForm.find('input[type=checkbox]:not(:checked)');
        if (uncheckedCheckboxes.length) {
          let uncheckedCheckboxesData = '';

          uncheckedCheckboxes.each(function() {
            const _this = $(this);
            const name = _this.attr('name');

            if (name) {
              uncheckedCheckboxesData += `&${name}=off`;
            }
          });

          formData += uncheckedCheckboxesData;
        }

        const data = {
          'action': constants.ACTION_UPDATE_BULLETIN,
          'ajaxNonce': window.BULLETINWP['ajaxNonce'],
          'bulletin': bulletinID,
          'formData': formData,
        };

        axios.post(window.BULLETINWP['ajaxUrl'], qs.stringify(data)).then((axiosResponse) => {
          if (200 === axiosResponse.status) {
            const response = axiosResponse.data;
            if (response.success) {
              let isActivated = response.data['is_activated'];
              const editPageParams = response.data['edit_page_params'];
              const bulletinLink = response.data['bulletin_link'];
              const updatedData = response.data['updated_data'];
              const message = response.data['message'];
              const viewButton = thisBulletinForm.find('.view-button');
              let viewLinkHTML = '';

              if (buttonStatus === 'publish') {
                defaultLabel = window.BULLETINWP['translations']['saveBulletin'];
                loadingLabel = window.BULLETINWP['translations']['saving'] + '...';
                submitButton.attr('data-button-status', 'edit');
                submitButton.attr('data-default-label', defaultLabel);
                submitButton.attr('data-loading-label', loadingLabel);
                submitButton.data('button-status', 'edit');
                submitButton.data('default-label', defaultLabel);
                submitButton.data('loading-label', loadingLabel);
                buttonStatus = 'edit';
                if (!addSchedule.is(':checked')) {
                  inputIsActive.prop('checked', true);
                  activeSwitchLabel.text(checkboxWrapper.data('checked-label'));
                  isActivated = true;
                }
              }

              if (!bulletinID) {
                const params = editPageParams;
                const pageHeading = $('h1.wp-heading-inline');

                helpers.pushStateHistory(!$.isEmptyObject(params) ? '?' + $.param(params) : '');

                if (pageHeading.length) {
                  pageHeading.text(window.BULLETINWP['translations']['editBulletin']);
                }
              }

              if (bulletinLink.length && viewButton.length) {
                let viewButtonLabel = window.BULLETINWP['translations']['preview'];
                let viewLinkLabel = viewButtonLabel;

                if (isActivated) {
                  viewButtonLabel = window.BULLETINWP['translations']['view'];
                  viewLinkLabel = window.BULLETINWP['translations']['viewNow'];
                }

                viewButton.prop('href', bulletinLink);
                viewButton.text(viewButtonLabel);
                viewButton.show();

                if (viewLinkLabel.length) {
                  viewLinkHTML = `<a href="${bulletinLink}" target="_blank">${viewLinkLabel}</a>`;
                }
              }

              if (!$.isEmptyObject(updatedData)) {
                $.each(updatedData, function(key, data) {
                  const formElement = thisBulletinForm.find(`[name="${key}"]`);

                  if (formElement.length) {
                    formElement.val(data);
                  }
                });
              }

              submitButton.text(defaultLabel);
              submitButton.prop('disabled', false);
              formMessage.html(`${message} ${viewLinkHTML}`);
              formMessage.show();
            }
          }
        }).catch((error) => {
          throw new Error(error);
        });
      });
    }
  });
};

export default bulletinFormFunction;
