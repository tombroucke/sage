import Headroom from "headroom.js";

export default class Header {
  constructor(el) {
    el ? this.init(el) : console.error('No header found');
  }

  init(el) {
    this.el = el;
    this.dropdowns = this.el.querySelectorAll('.menu-item--has-submenu');
    this.navbarToggler = this.el.querySelector('.navbar-toggler');

    this.headroom().init();
    this.bindEvents();
  }

  headroom() {
    const header = this;
    const headroom  = new Headroom(this.el, {
      offset: {
          up: 100,
          down: 50,
      },
      classes : {
        initial : "banner",
        pinned : "banner--pinned",
        unpinned : "banner--unpinned",
        top : "banner--top",
        notTop : "banner--not-top",
        bottom : "banner--bottom",
        notBottom : "banner--not-bottom",
        frozen: "banner--frozen",
      },
      onUnpin : function() {
        header.closeSubmenus();
      },
    });
    return headroom;
  }

  bindEvents() {
    const header = this;
    this.navbarToggler.addEventListener('click', this.toggleMobileNav);
    document.body.addEventListener('click', function(e){
      if(e.target.closest('.menu-item--has-submenu') === null) {
        header.closeSubmenus();
      }
    });

    for (let index = 0; index < this.dropdowns.length; index++) {
      const dropdown = this.dropdowns[index];
      const link = dropdown.querySelector('a');
      link.addEventListener('click', function(e){
        e.preventDefault();
        dropdown.classList.toggle('menu-item--open');
      });
    }
  }

  toggleMobileNav() {
    document.body.classList.toggle('primary-nav-open');
  }

  closeSubmenus() {
    for (let index = 0; index < this.dropdowns.length; index++) {
      const dropdown = this.dropdowns[index];
      dropdown.classList.remove('menu-item--open');
    }
  }
}
