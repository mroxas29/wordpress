import axios from 'axios';
import qs from 'qs';
import * as constants from '../util/constants';

const _import = (bulletinwpAdmin) => {
  jQuery(document).ready(function () {
    const importBulletinsButtonWrapper = bulletinwpAdmin.find('.import-bulletins-button-wrapper');
    if (importBulletinsButtonWrapper.length) {
      const isFileValid = function(filename) {
        const extension = filename.split('.').pop();

        return (extension === 'csv');
      };

      const convertCSVToJSON = function(str, delimiter = ',') {
        const titles = str.slice(0, str.indexOf('\n')).split(delimiter);
        const rows = str.slice(str.indexOf('\n') + 1).split('\n');
        const cleanRows = rows.filter(item => item);

        return cleanRows.map(row => {
          const values = row.split(delimiter);

          return titles.reduce((object, curr, i) => (object[curr.trim()] = values[i], object), {});
        });
      };

      const importInput = importBulletinsButtonWrapper.find('input[type="file"]').get(0);
      const importButton = importBulletinsButtonWrapper.find('button');
      const defaultLabel = importButton.data('default-label');
      const loadingLabel = importButton.data('loading-label');
      const resultsMessage = importBulletinsButtonWrapper.find('.import-results-message');

      importButton.on('click', function(e) {
        e.preventDefault();

        importButton.prop('disabled', true);
        importButton.text(loadingLabel);
        resultsMessage.hide();
        resultsMessage.html('');

        let hasError = false;

        if (importInput.value === '') {
          hasError = true;
          resultsMessage.show();
          resultsMessage.html(`${window.BULLETINWP['translations']['fileIsRequired']}`);
        } else if (!isFileValid(importInput.files[0].name)) {
          hasError = true;
          resultsMessage.show();
          resultsMessage.html(`${window.BULLETINWP['translations']['fileIsInvalid']}`);
        }

        if (hasError) {
          importButton.prop('disabled', false);
          importButton.text(defaultLabel);

          return false;
        }

        let csvData = '';
        const file = importInput.files[0];
        const reader = new FileReader();
        reader.readAsText(file);
        reader.onload = (function() {
          csvData = reader.result;

          if (csvData === '' || csvData === null) {
            resultsMessage.show();
            resultsMessage.html(`${window.BULLETINWP['translations']['emptyCSVFile']}`);
            importButton.prop('disabled', false);
            importButton.text(defaultLabel);

            return false;
          }

          const data = {
            'action': constants.ACTION_IMPORT_BULLETINS,
            'ajaxNonce': window.BULLETINWP['ajaxNonce'],
            'bulletins': convertCSVToJSON(csvData, ','),
          };

          axios.post(window.BULLETINWP['ajaxUrl'], qs.stringify(data)).then((axiosResponse) => {
            if (200 === axiosResponse.status) {
              const response = axiosResponse.data;

              if (response.success) {
                const message = response.data['message'];

                importButton.prop('disabled', false);
                importButton.text(defaultLabel);
                resultsMessage.show();
                resultsMessage.html(message);
              }
            }
          }).catch((error) => {
            throw new Error(error);
          });
        });
      });
    }
  });
};

export default _import;
