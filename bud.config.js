// @ts-check
import purgecssWithWordpress from 'purgecss-with-wordpress';
import customPurgeSafelist from './purge-safelist.cjs';
import customPurgeBlocklist from './purge-blocklist.cjs';
import {basename, join} from 'node:path';

/**
* Compiler configuration
*
* @see {@link https://roots.io/docs/sage sage documentation}
* @see {@link https://bud.js.org/guides/configure bud.js configuration guide}
*
* @param {import('@roots/bud').Bud} app
*/
export default async (app) => {
  const mappedAssets = async (dir, type) => {
    const assets = await app.glob([`@src/${dir}/[!_]*${type}`]);

    let reducedassets = assets.map(function(asset) {
      return join(dir, basename(asset, type));
    }).reduce(function(a, c) {
      return {...a, [c.replace(/styles\/|scripts\//gi, '')]: [c]};
    }, {});
    return reducedassets;
  }

  /**
  * Application assets & entrypoints
  *
  * @see {@link https://bud.js.org/docs/bud.entry}
  * @see {@link https://bud.js.org/docs/bud.assets}
  */

  app
  .entry({
    'app': ["@scripts/app", "@styles/app"],
    'fonts': ["@styles/fonts"],
    'fancybox': ["@styles/fancybox"],
    'swiper': ["@styles/swiper"],
    'modal': ["@styles/modal"],
    'forms': ["@styles/forms"],
    'tables': ["@styles/tables"],
    ...(await mappedAssets('styles/blocks', '.scss')),
    ...(app.isProduction ? {editor: ["@scripts/editor", "@styles/editor"]} : {editor: ["@scripts/editor", "@styles/editor-basic"]}),
  })

  /**
  * Enable sourcemaps
  */
  .when(app.isDevelopment, app => app.devtool())

  /**
  * PurgeCSS
  */
  .when(app.isProduction, app => {
    app.purge.setSafelist(purgecssWithWordpress.safelist.concat(customPurgeSafelist.safelist));
    app.purge.setContent([
      app.path('@styles/**/*.scss'),
      app.path('@views/**/*.blade.php'),
      app.path('./app/**/*.php'),
      app.path('./index.php'),
      app.path('@modules/@fancyapps/ui/dist/fancybox/fancybox.css'),
      app.path('@modules/swiper/**/*.css'),
      app.path('@modules/swiper/modules/pagination/pagination.min.css'),
    ]);
    app.purge.setBlocklist(customPurgeBlocklist.blocklist);
  })

  .runtime('single')

  /**
  * Directory contents to be included in the compilation
  */
  .assets(["images"])

  /**
  * Development server settings
  *
  * @see {@link https://bud.js.org/docs/bud.setUrl}
  * @see {@link https://bud.js.org/docs/bud.setProxyUrl}
  * @see {@link https://bud.js.org/docs/bud.watch}
  */
  .watch(["resources/views/**/*", "app/**/*"])

  .setPath({'@certs' : '/Users/tombroucke/Library/Application Support/Herd/config/valet/Certificates'})
  .proxy("https://sage.test")
  .serve({
    host: "sage.test",
    cert: app.path('@certs/sage.test.crt'),
    key: app.path('@certs/sage.test.key'),
  })

  /**
  * URI of the `public` directory
  */
  .setPublicPath("/app/themes/sage/public/");
};
