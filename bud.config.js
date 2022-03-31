/**
 * @typedef {import('@roots/bud').Bud} bud
 *
 * @param {bud} app
 */
module.exports = async (app) => {
  app
    /**
     * Application entrypoints
     *
     * Paths are relative to your resources directory
     */
    .entry({
      app: ['@scripts/app', '@styles/app'],
      editor: ['@scripts/editor', '@styles/editor'],
    })

    .when(app.isProduction, app => {
      app.purgecss({
        enabled: false,
        content: [
          app.path('resources/views/**/*.blade.php'),
          app.path('app/**/*.php'),
          app.path('index.php'),
        ],
        safelist: require('purgecss-with-wordpress').safelist.concat(require('./purge-safelist').safelist),
      })
    })

    /**
     * These files should be processed as part of the build
     * even if they are not explicitly imported in application assets.
     */
    .assets(['images'])

    /**
     * These files will trigger a full page reload
     * when modified.
     */
    .watch('resources/views/**/*', 'app/**/*')

    /**
     * Target URL to be proxied by the dev server.
     *
     * This should be the URL you use to visit your local development server.
     */
    .proxy('https://%devurl%')

    /**
     * Development URL to be used in the browser.
     */
    .serve('http://%devurl%:3000');
};
