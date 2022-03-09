const mix = require('laravel-mix');
const path = require('path');
require('laravel-mix-purgecss');
require('@tinypixelco/laravel-mix-wp-blocks');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix
  .setPublicPath('./public')
  .browserSync('https://development.local');

mix
  .sass('resources/styles/app.scss', 'styles')
  .sass('resources/styles/editor.scss', 'styles')
  .purgeCss({
    extend: { content: [path.join(__dirname, 'index.php')] },
    safelist: require('purgecss-with-wordpress').safelist.concat(require('./purge-safelist').safelist),
  })
  .options({
    processCssUrls: false,
  });

mix
  .js('resources/scripts/app.js', 'scripts')
  .blocks('resources/scripts/editor.js', 'scripts')
  .autoload({ jquery: ['$', 'window.jQuery'] })
  .extract();

mix
  .copyDirectory('resources/images', 'public/images')
  .copyDirectory('resources/fonts', 'public/fonts');

mix
  .version();
