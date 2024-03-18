import domReady from '@roots/sage/client/dom-ready';

import BlockLoader from './block-loader.js';
import Header from './components/header.js';

import './config.js';

/**
 * Application entrypoint
 */
domReady(async () => {
  // Load block scripts
  (new BlockLoader()).load();

  // Initialize header
  new Header(document.querySelector('.banner'));

  // Initialize fancybox
  const fancyboxElements = document.querySelectorAll('[data-fancybox]');
  if (fancyboxElements.length > 0) {
    const { Fancybox } = await import('@fancyapps/ui');
    Fancybox.bind('[data-fancybox]');
  }
});

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
import.meta.webpackHot?.accept(console.error);
