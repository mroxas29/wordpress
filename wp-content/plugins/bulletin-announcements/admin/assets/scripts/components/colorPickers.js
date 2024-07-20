const colorPickers = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const colorPickerInputs = bulletinwpAdmin.find('.color-picker-input');
    if (colorPickerInputs.length) {
      colorPickerInputs.each(function () {
        const _this = $(this);

        _this.wpColorPicker();
      });
    }
  });
};

export default colorPickers;
