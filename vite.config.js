import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin } from '@roots/vite-plugin';

import fs from 'fs';
import path from 'path';

// Set APP_URL if it doesn't exist for Laravel Vite plugin
if (! process.env.APP_URL) {
  process.env.APP_URL = 'http://example.com';
}

const blockDir = path.resolve(__dirname, 'resources/styles/blocks');

const assets = [
  'resources/styles/app.scss',
  'resources/scripts/app.js',
  'resources/styles/editor.scss',
  'resources/scripts/editor.js',
  'resources/styles/fancybox.scss',
  'resources/styles/fonts.scss',
  'resources/styles/forms.scss',
  'resources/styles/modal.scss',
  'resources/styles/swiper.scss',
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
  base: '/app/themes/themename/public/build/',
  plugins: [
    laravel({
      input: assets.concat(blockFiles.map(file => `resources/styles/blocks/${file}`)),
      refresh: true,
      assets: ['resources/images/**', 'resources/fonts/**'],
    }),

    wordpressPlugin(),
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
        silenceDeprecations: ['if-function', 'color-functions', 'global-builtin', 'import']
      },
    }
  },
})
