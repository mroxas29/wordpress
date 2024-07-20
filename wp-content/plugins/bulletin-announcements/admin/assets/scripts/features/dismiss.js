import helpers from '../util/helpers';

const dismiss = (bulletinwpAdmin) => {
  jQuery(document).ready(function($) {
    const dismissButton = bulletinwpAdmin.find('.dismiss-button');

    if (dismissButton.length) {
      dismissButton.each(function() {
        const cookieName = $(this).data('dismiss-cookie');
        const parentContainer = $(this).parent('.dismiss-container').first();
        const cookieDataString = helpers.docLocalStorage.getItem(cookieName);

        if (cookieDataString) {
          const cookieData = JSON.parse(cookieDataString);
          const expiryDate = Date.parse(cookieData.expires);

          if (expiryDate < Date.parse(new Date())) {
            helpers.docLocalStorage.removeItem(cookieName);
            parentContainer.show();
          } else {
            parentContainer.remove();
          }
        } else {
          parentContainer.show();
        }
      });

      dismissButton.on('click', function(e) {
        e.preventDefault();

        const cookieName = $(this).data('dismiss-cookie');
        const parentContainer = $(this).parent('.dismiss-container').first();
        const millisecondsInOneMonth = 30 * 24 * 60 * 60 * 1000;

        if (helpers.docLocalStorage.getItem(cookieName)) {
          parentContainer.remove();
        } else {
          helpers.docLocalStorage.setItem(cookieName, millisecondsInOneMonth);
          parentContainer.remove();
        }
      });
    }
  });
};

export default dismiss;
