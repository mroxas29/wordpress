const modal = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const modalButtonWrapper = bulletinwpAdmin.find('.modal-button-wrapper');
    if (modalButtonWrapper.length) {
      modalButtonWrapper.each(function() {
        const thisModalButtonWrapper = $(this);

        const modalButton = thisModalButtonWrapper.find('.modal-button');
        const overlayTarget = thisModalButtonWrapper.data('overlay');
        const overlayElement = bulletinwpAdmin.find(overlayTarget);
        const modalTarget = thisModalButtonWrapper.data('id-modal');
        const modalElement = bulletinwpAdmin.find(modalTarget);

        // Open modal
        modalButton.on('click', function(){
          toggleModal();
        });

        // Close modal
        overlayElement.on('click', function(){
          toggleModal();
        });

        document.onkeydown = function(evt) {
          evt = evt || window.event;
          let isEscape = false;
          if ('key' in evt) {
            isEscape = (evt.key === 'Escape' || evt.key === 'Esc');
          } else {
            isEscape = (evt.keyCode === 27);
          }
          if (isEscape && modalElement.find('modal-active')) {
            toggleModal();
          }
        };

        function toggleModal () {
          modalElement.toggleClass('opacity-0');
          modalElement.toggleClass('pointer-events-none');
          modalElement.toggleClass('modal-active');
        }
      });
    }
  });
};

export default modal;
