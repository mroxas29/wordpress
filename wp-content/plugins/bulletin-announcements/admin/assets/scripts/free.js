// MAIN
import main from './main';

// STYLES
import '../styles/free.scss';

// PUBLIC PATH
__webpack_public_path__ = window.BULLETINWP['buildPath'];

jQuery(document).ready(function ($) {
  const bulletinwpAdmin = $(`#${window.BULLETINWP['pluginSlug']}-admin`);
  if (bulletinwpAdmin.length) {
    // MAIN
    main();
  }
});
