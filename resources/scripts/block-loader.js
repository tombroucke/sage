export default class BlockLoader {
  constructor () {
    this.initBlocks();
  }

  initBlocks() {
    let blocks = [];
    const elements = document.querySelectorAll('[class*="wp-block-"]');
    Array.from(elements).map(function(element){
      blocks = blocks.concat(
        Array
          .from(element.classList)
          .filter((className) => className.startsWith('wp-block-'))
          .filter((className) => className.indexOf('_') === -1)
      );
    })
    this.blocks = blocks.filter((x, i, a) => a.indexOf(x) == i);
  }

  load() {
    this.blocks.map(async function(block){
      const blockName = block.replace('wp-block-', '');
      await import(
        /* webpackChunkName: "[request]" */
        `./blocks/${blockName}.js`
      )
      .catch((err) => {
        if (import.meta.env.MODE === 'development') {
          console.log(err);
        }
      });
    });
  }
}
