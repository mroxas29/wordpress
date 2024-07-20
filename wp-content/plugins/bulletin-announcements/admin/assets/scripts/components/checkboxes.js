const checkboxes = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const checkboxWrapper = bulletinwpAdmin.find('.checkbox-wrapper');
    const inputIsActive = bulletinwpAdmin.find('input[name="isActivated"]');
    const isActiveLabel = bulletinwpAdmin.find('span.active-switch-label');
    const uncheckedIsActiveLabel = bulletinwpAdmin.find('.active-data-label').data('unchecked-label');
    if (checkboxWrapper.length) {
      checkboxWrapper.each(function() {
        const thisCheckboxWrapper = $(this);

        thisCheckboxWrapper.find('input[type="checkbox"]').on('change', function() {
          const _this = $(this);
          const checkedLabel = thisCheckboxWrapper.data('checked-label');
          const uncheckedLabel = thisCheckboxWrapper.data('unchecked-label');
          const hideShowElements = thisCheckboxWrapper.data('hide-show-elements');
          const label = thisCheckboxWrapper.find('span.label');

          if (checkedLabel && uncheckedLabel) {
            if (_this.is(':checked')) {
              // Change to checked label
              label.text(checkedLabel);
            } else {
              // Change to unchecked label
              label.text(uncheckedLabel);
            }
          }

          if (hideShowElements && bulletinwpAdmin.find(hideShowElements).length) {
            if (_this.is(':checked')) {
              // Show the elements
              bulletinwpAdmin.find(hideShowElements).show();
            } else {
              // Hide the elements
              bulletinwpAdmin.find(hideShowElements).hide();
            }
          }
        });

        thisCheckboxWrapper.find('input[name="addSchedule"]').on('change', function() {
          const _this = $(this);

          if (_this.is(':checked')) {
            if (inputIsActive.is(':checked')) {
              inputIsActive.prop('disabled', false);
              isActiveLabel.text(uncheckedIsActiveLabel);
              inputIsActive.prop('checked', false);
            }

            inputIsActive.prop('disabled', true);
          } else {
            inputIsActive.prop('disabled', false);
          }
        });
      });
    }
  });
};

export default checkboxes;
