// @ts-check
import purgecssWithWordpress from 'purgecss-with-wordpress';
import customPurgeSafelist from './purge-safelist.js';

/**
 * Build configuration
 *
 * @see {@link https://bud.js.org/guides/getting-started/configure}
 * @param {import('@roots/bud').Bud} app
 */
export default async (app) => {
  app
    /**
     * Application entrypoints
     */
    .entry({
      app: ["@scripts/app", "@styles/app"],
      editor: ["@scripts/editor", "@styles/editor"],
    })

    .when(app.isProduction, app => {
      app.purgecss({
        content: [
          app.path('@views/**/*.blade.php'),
          app.path('./app/**/*.php'),
          app.path('./index.php'),
          app.path('@modules/@fancyapps/ui/dist/fancybox.css'),
          app.path('@modules/swiper/swiper.min.css'),
          app.path('@modules/swiper/modules/pagination/pagination.min.css'),
        ],
        safelist: purgecssWithWordpress.safelist.concat(customPurgeSafelist.safelist),
      })
    })

    /**
     * Directory contents to be included in the compilation
     */
    .assets(["images"])

    /**
     * Matched files trigger a page reload when modified
     */
    .watch(["resources/views/**/*", "app/**/*"])

    /**
     * Proxy origin (`WP_HOME`)
     */
    .proxy("https://development.local")

    /**
     * Development origin
     */
    .serve("http://development.local:3000")

    /**
     * URI of the `public` directory
     */
    .setPublicPath("/app/themes/sage/public/");
};
