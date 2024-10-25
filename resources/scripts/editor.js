import {unregisterBlockStyle, registerBlockStyle} from '@wordpress/blocks';

/**
 * Editor entrypoint
 */
wp.domReady(() => {
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
