<header class="banner">
  <div class="bg-light">
    <div class="container container--wide">
      @if (has_nav_menu('top_navigation'))
        <div class="d-flex justify-content-end">
          @include('partials.navigation', ['nav_menu' => 'top_navigation'])
        </div>
      @endif
    </div>
  </div>

  <div class="container container--wide">
    <div class="d-flex justify-content-between align-items-center w-100">
      <a class="brand" href="{{ home_url('/') }}">
        {{ $siteName }}
      </a>
      @if (has_nav_menu('primary_navigation'))
        @include('partials.navigation')
      @endif
    </div>
  </div>
</header>
