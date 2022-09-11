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
    unregisterBlockType('core/media-text');
    unregisterBlockType('core/navigation');
    unregisterBlockType('core/cover-image');
    unregisterBlockType('core/cover');
    unregisterBlockType('core/file');
    unregisterBlockType('core/gallery');
    unregisterBlockType('core/latest-comments');
    unregisterBlockType('core/latest-posts');
    unregisterBlockType('core/post-author');
    unregisterBlockType('core/post-comments');
    unregisterBlockType('core/post-excerpt');
    unregisterBlockType('core/post-title');
    unregisterBlockType('core/post-title');
    unregisterBlockType('core/post-template');
    unregisterBlockType('core/query-loop');
    unregisterBlockType('core/query-pagination');
    unregisterBlockType('core/site-logo');
    unregisterBlockType('core/social-links');
    unregisterBlockType('core/tag-cloud');
    unregisterBlockType('core/verse');
    unregisterBlockType('core/post-featured-image');
    unregisterBlockType('core/site-title');
    unregisterBlockType('core/site-tagline');
    unregisterBlockType('core/query');
    unregisterBlockType('core/query-title');
    unregisterBlockType('core/post-date');
    unregisterBlockType('core/post-content');
    unregisterBlockType('core/post-terms');
    unregisterBlockType('core/term-description');
    unregisterBlockType('core/post-navigation-link');
    unregisterBlockType('core/loginout');
  });
};

/**
 * Initialize
 *
 * @see https://webpack.js.org/api/hot-module-replacement
 */
domReady(main);
import.meta.webpackHot?.accept(main);
