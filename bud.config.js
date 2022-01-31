/**
 * @typedef {import('@roots/bud').Bud} bud
 *
 * @param {bud} app
 */
module.exports = (app) =>
  app
    /**
     * Application entrypoints
     *
     * Paths are relative to your resources directory
     */
    .entry({
      app: ['scripts/app.js', 'styles/app.scss'],
      editor: ['scripts/editor.js', 'styles/editor.scss'],
    })

    .purgecss({
      content: [
        app.path('project', 'resources/views/**/*.blade.php'),
        app.path('project', 'app/**/*.php'),
        app.path('project', 'index.php'),
      ],
      safelist: require('purgecss-with-wordpress').safelist.concat(require('./purge-safelist').safelist),
    })

    /**
     * These files should be processed as part of the build
     * even if they are not explicitly imported in application assets.
     */
    .assets([app.path('src', 'images')])

    /**
     * These files will trigger a full page reload
     * when modified.
     */
    .watch([
      'resources/views/**/*.blade.php',
      'app/View/**/*.php',
    ])

    /**
     * Target URL to be proxied by the dev server.
     *
     * This is your local dev server.
     */
    .proxy('https://development.local');
