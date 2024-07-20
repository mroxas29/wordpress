import MarkdownIt from 'markdown-it';
import { full as emoji } from 'markdown-it-emoji';

const markdown = (bulletinwpAdmin) => {
  jQuery(document).ready(function ($) {
    const bulletinItem = bulletinwpAdmin.find(`.${window.BULLETINWP['pluginSlug']}-support-markdown`);
    if (bulletinItem.length) {
      // Content
      const bulletinContents = bulletinItem.find(`.${window.BULLETINWP['pluginSlug']}-markdown-items`);
      if (bulletinContents.length) {
        bulletinContents.each(function() {
          const _this = $(this);
          const md = new MarkdownIt({
            html: true,
            breaks: true,
            linkify: true,
          }).use(emoji);
          const content = _this.html().trim();
          const markdownContent = md.render(content);

          _this.html(markdownContent);
        });
      }
    }
  });
};

export default markdown;
