import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin } from '@roots/vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss'
import purgecssWithWordpress from 'purgecss-with-wordpress';
import customPurgeSafelist from './purgecss-safelist.js';
import customPurgeBlocklist from './purgecss-blocklist.js';

import fs from 'fs';
import path from 'path';

const blockDir = path.resolve(__dirname, 'resources/styles/blocks');

const assets = [
  'resources/styles/app.scss',
  'resources/scripts/app.js',
  'resources/styles/editor.scss',
  'resources/scripts/editor.js',
  'resources/styles/fonts.scss',
  'resources/styles/forms.scss',
  'resources/styles/fancybox.scss',
  'resources/styles/swiper.scss',
  'resources/styles/modal.scss',
  'resources/styles/forms.scss',
  'resources/styles/tables.scss',
];

const blockFiles = fs.readdirSync(blockDir)
  .filter(f => f.endsWith('.scss'))
  .filter(function(file) {
    const isPartial = file.startsWith('_');
    const isIndex = file === 'index.scss';
    const isHidden = file.startsWith('.');
    return !isPartial && !isIndex && !isHidden;
  });

export default defineConfig({
  base: '/app/themes/%themename%/public/build/',
  plugins: [
    laravel({
      input: assets.concat(blockFiles.map(file => `resources/styles/blocks/${file}`)),
      refresh: true,
    }),

    wordpressPlugin(),

    purge({
      paths: [
        './app/**/*.php',
        './resources/styles/**/*.scss',
        './resources/views/**/*.blade.php',
        './node_modules/@fancyapps/ui/dist/fancybox/fancybox.css',
        './node_modules/swiper/**/*.css',
        './node_modules/swiper/modules/pagination/pagination.min.css',
      ],
      safelist: purgecssWithWordpress.safelist.concat(customPurgeSafelist.safelist),
      blocklist: customPurgeBlocklist.blocklist,
    })
  ],
  resolve: {
    alias: {
      '@scripts': '/resources/scripts',
      '@styles': '/resources/styles',
      '@views': '/resources/views',
      '@fonts': '/resources/fonts',
      '@images': '/resources/images',
      '@modules': '/node_modules',
    },
  },
  css: {
    preprocessorOptions: {
      scss: {
        silenceDeprecations: ['mixed-decls', 'color-functions', 'global-builtin', 'import']
      },
    }
  },
})
