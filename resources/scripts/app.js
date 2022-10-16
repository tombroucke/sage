import {domReady} from '@roots/sage/client';

import BlockLoader from './block-loader';
import Header from './components/header';

import './config';

/**
 * app.main
 */
const main = async (err) => {
  if (err) {
    // handle hmr errors
    console.error(err);
  }

  // Load block scripts
  (new BlockLoader()).load();

  // Initialize header
  new Header(document.querySelector('.banner'));
};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);
