import {registerBlockStyle, unregisterBlockStyle, unregisterBlockType} from '@wordpress/blocks';

/**
 * Editor entrypoint
 */
wp.domReady(() => {
  unregisterBlockType('core/audio');
  unregisterBlockType('core/avatar');
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
  unregisterBlockType('core/read-more');
  unregisterBlockType('core/term-description');
  unregisterBlockType('core/post-navigation-link');
  unregisterBlockType('core/loginout');

  unregisterBlockStyle('core/separator', 'dots');
  unregisterBlockStyle('core/separator', 'wide');

  registerBlockStyle('core/paragraph', {
    name: 'lead',
    label: 'Lead',
  });
});

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
import.meta.webpackHot?.accept(console.error);
