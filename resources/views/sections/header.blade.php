<header class="banner mb-5">
  <div class="banner__top spacing-outer bg-dark text-white py-2">
    <div class="container container--wide">
      {!! __('This is the top header section', 'sage') !!}
      @if (has_nav_menu('top_navigation'))
        <div class="d-flex justify-content-end">
          @include('partials.navigation', ['nav_menu' => 'top_navigation'])
        </div>
      @endif
    </div>
  </div>
  <div class="banner__primary spacing-outer bg-primary text-white py-2">
    <div class="container container--wide">
      <div class="d-flex justify-content-between align-items-center w-100">
        <a class="brand fw-bold text-decoration-none" href="{{ home_url('/') }}" aria-label="{{ __('Home', 'sage') }}">
          {{ $siteName }}
        </a>
        @if (has_nav_menu('primary_navigation'))
          @include('partials.navigation')
        @endif
      </div>
    </div>
  </div>
</header>
