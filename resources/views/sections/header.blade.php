<header class="banner bg-white">

  <div class="banner__top spacing-outer">
    <div class="has-global-padding is-layout-constrained">
      <div class="alignwide">
        <div class="d-flex justify-content-between">
          <div>
            <span>{!! __('This is the top header section', 'sage') !!}</span>
          </div>
          @includeWhen(has_nav_menu('top_navigation'), 'partials.navigation-top')
        </div>
      </div>
    </div>
  </div>

  <div class="banner__primary spacing-outer">
    <div class="has-global-padding is-layout-constrained">
      <div class="alignwide">
        <div class="d-flex justify-content-between align-items-center w-100 flex-wrap">
          <a
            class="brand fw-bold text-decoration-none"
            href="{{ home_url('/') }}"
            aria-label="{{ __('Home', 'sage') }}"
          >
            @svg('logo', ['height' => '2em'])
          </a>
          @includeWhen(has_nav_menu('primary_navigation'), 'partials.navigation-primary')
        </div>
      </div>
    </div>
  </div>

</header>
