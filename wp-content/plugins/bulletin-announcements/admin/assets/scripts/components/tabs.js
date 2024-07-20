const tabs = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const tabsWrapper = bulletinwpAdmin.find('.tabs-wrapper');
    if (tabsWrapper.length) {
      const tabItem = tabsWrapper.find('.tabs > .tab-item');
      const tabPane = tabsWrapper.find('.tabs-content > .tab-pane');

      tabItem.on('click', function(e) {
        e.preventDefault();

        const _this = $(this);
        const thisTabItem = _this.closest('.tab-item');
        const targetPane = _this.data('tab');

        tabItem.removeClass('active');
        thisTabItem.addClass('active');
        tabPane.removeClass('active');

        if (tabsWrapper.find(targetPane).length) {
          tabsWrapper.find(targetPane).addClass('active');
        }
      });
    }
  });
};

export default tabs;
