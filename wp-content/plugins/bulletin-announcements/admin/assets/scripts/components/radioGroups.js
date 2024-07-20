const radioGroups = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const radioGroupWrappers = bulletinwpAdmin.find('.radio-group-wrapper');
    if (radioGroupWrappers.length) {
      radioGroupWrappers.each(function() {
        const thisRadioGroupWrapper = $(this);

        thisRadioGroupWrapper.find('input[type="radio"]').on('change', function() {
          const thisRadio = $(this);
          const name = thisRadio.attr('name');
          const showElements = thisRadio.data('show-elements');
          const hideElements = thisRadio.data('hide-elements');
          const allRadios = thisRadioGroupWrapper.find(`input[type="radio"][name="${name}"]`);

          allRadios.each(function() {
            const _this = $(this);
            const radioShowElements = _this.data('show-elements');
            const radioHideElements = _this.data('hide-elements');

            // Hide the elements
            if (radioShowElements) {
              bulletinwpAdmin.find(radioShowElements).hide();
            }

            // Show the elements
            if (radioHideElements) {
              bulletinwpAdmin.find(radioHideElements).show();
            }
          });

          // Show the elements
          if (showElements) {
            bulletinwpAdmin.find(showElements).show();
          }

          // Hide the elements
          if (hideElements) {
            bulletinwpAdmin.find(hideElements).hide();
          }
        });
      });
    }
  });
};

export default radioGroups;
