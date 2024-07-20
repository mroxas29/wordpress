// COMPONENTS
import checkboxes from './components/checkboxes';
import colorPickers from './components/colorPickers';
import modal from './components/modal';
import radioGroups from './components/radioGroups';
import tabs from './components/tabs';
import textareas from './components/textareas';

// COMMON
import bulletinForm from './common/bulletinForm';

// FEATURES
import _export from './features/export';
import _import from './features/import';
import markdown from './features/markdown';
import dismiss from './features/dismiss';

// PAGES
import bulletins from './pages/bulletins';
import settings from './pages/settings';

const main = () => {
  jQuery(document).ready(function ($) {
    const bulletinwpAdmin = $(`#${window.BULLETINWP['pluginSlug']}-admin`);
    if (bulletinwpAdmin.length) {
      // COMPONENTS
      // Checkboxes
      checkboxes(bulletinwpAdmin);
      // Color Pickers
      colorPickers(bulletinwpAdmin);
      // modal
      modal(bulletinwpAdmin);
      // Radio Groups
      radioGroups(bulletinwpAdmin);
      // Tabs
      tabs(bulletinwpAdmin);
      // Textareas
      textareas(bulletinwpAdmin);

      // COMMON
      bulletinForm(bulletinwpAdmin);

      // FEATURES
      _export(bulletinwpAdmin);
      _import(bulletinwpAdmin);
      markdown(bulletinwpAdmin);
      dismiss(bulletinwpAdmin);

      // PAGES
      bulletins(bulletinwpAdmin);
      settings(bulletinwpAdmin);
    }
  });
};

export default main;
