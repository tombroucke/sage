import {domReady} from '@roots/sage/client';
import {unregisterBlockType} from '@wordpress/blocks';

/**
 * editor.main
 */
const main = (err) => {
  if (err) {
    // handle hmr errors
    console.error(err);
  }
  window._wpLoadBlockEditor.then(() => {
    unregisterBlockType('core/button');
    unregisterBlockType('core/buttons');
  });
};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);
