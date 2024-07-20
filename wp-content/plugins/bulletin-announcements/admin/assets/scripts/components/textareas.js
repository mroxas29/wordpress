const textareas = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const textareaInputs = bulletinwpAdmin.find('.textarea-input');
    if (textareaInputs.length) {
      textareaInputs.each(function () {
        const thisInput = $(this);

        thisInput.on('input', function() {
          const _this = $(this);

          _this.height(0);
          _this.height(this.scrollHeight);
        });
      });
    }
  });
};

export default textareas;
