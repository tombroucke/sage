import purgecss from '@fullhuman/postcss-purgecss';
import purgecssWithWordpress from 'purgecss-with-wordpress';
import customPurgeSafelist from './purgecss-safelist.js';
import customPurgeBlocklist from './purgecss-blocklist.js';

export default {
  plugins: [
    purgecss.default({
      content: [
        './app/**/*.php',
        './resources/styles/**/*.scss',
        './resources/views/**/*.blade.php',
        './node_modules/@fancyapps/ui/dist/fancybox/fancybox.css',
        './node_modules/swiper/**/*.css',
        './node_modules/swiper/modules/pagination/pagination.min.css',
      ],
      safelist: purgecssWithWordpress.safelist.concat(customPurgeSafelist.safelist),
      blocklist: customPurgeBlocklist.blocklist,
      defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
    }),
  ],
};
