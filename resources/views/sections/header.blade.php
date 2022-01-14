<header class="banner">
  <div class="container">
    <a class="brand" href="{{ home_url('/') }}">
      {{ $siteName }}
    </a>

    @if (has_nav_menu('primary_navigation'))
      @include('partials.navigation')
    @endif
  </div>
</header>
