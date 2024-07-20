import axios from 'axios';
import qs from 'qs';
import * as constants from '../util/constants';

const _export = (bulletinwpAdmin) => {
  jQuery(document).ready(function () {
    const exportBulletinsButtonWrapper = bulletinwpAdmin.find('.export-bulletins-button-wrapper');
    if (exportBulletinsButtonWrapper.length) {
      const exportButton = exportBulletinsButtonWrapper.find('button');
      const defaultLabel = exportButton.data('default-label');
      const loadingLabel = exportButton.data('loading-label');
      const resultsMessage = exportBulletinsButtonWrapper.find('.export-results-message');

      exportButton.on('click', function(e) {
        e.preventDefault();

        exportButton.prop('disabled', true);
        exportButton.text(loadingLabel);
        resultsMessage.hide();
        resultsMessage.html('');

        const data = {
          'action': constants.ACTION_EXPORT_BULLETINS,
          'ajaxNonce': window.BULLETINWP['ajaxNonce'],
        };

        axios.post(window.BULLETINWP['ajaxUrl'], qs.stringify(data)).then((axiosResponse) => {
          if (200 === axiosResponse.status) {
            const response = axiosResponse.data;

            if (response.success) {
              const message = response.data['message'];
              const filename = response.data['filename'];
              const bulletins = response.data['bulletins'];

              const downloadLink = document.createElement('a');
              const fileData = ['\ufeff'+bulletins];

              const blobObject = new Blob(fileData,{
                type: 'text/csv;charset=utf-8;'
              });

              const url = URL.createObjectURL(blobObject);
              downloadLink.href = url;
              downloadLink.download = filename;

              document.body.appendChild(downloadLink);
              downloadLink.click();
              document.body.removeChild(downloadLink);

              exportButton.prop('disabled', false);
              exportButton.text(defaultLabel);
              resultsMessage.show();
              resultsMessage.html(message);
            }
          }
        }).catch((error) => {
          throw new Error(error);
        });
      });
    }
  });
};

export default _export;
