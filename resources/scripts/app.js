import BlockLoader from './block-loader.js';
import Header from './components/header.js';

import.meta.glob([
  '../images/**',
  '../fonts/**',
]);


(async function () {
  // Load block scripts
  (new BlockLoader()).load();

  // Initialize header
  new Header(document.querySelector('.banner'));

  // Initialize fancybox
  const fancyboxElements = document.querySelectorAll('[data-fancybox]');
  if (fancyboxElements.length > 0) {
    const { Fancybox } = await import('@fancyapps/ui');
    Fancybox.bind('[data-fancybox]');
  }

  // async load bootstrap collapse
  const collapseElements = document.querySelectorAll('[data-bs-toggle="collapse"]');
  if (collapseElements.length > 0) {
    const { Collapse } = await import('bootstrap/js/dist/collapse'); // eslint-disable-line no-unused-vars
  }

  // async load bootstrap modal
  const modalElements = document.querySelectorAll('[data-bs-toggle="modal"]');
  if (modalElements.length > 0) {
    const { Modal } = await import('bootstrap/js/dist/modal'); // eslint-disable-line no-unused-vars
  }
}());
