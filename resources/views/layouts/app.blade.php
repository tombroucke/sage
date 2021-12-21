<a class="visually-hidden-focusable" href="#main">
  {{ __('Skip to content') }}
</a>

@include('partials.header')

  <main id="main" class="main">
    <div class="container">
      @yield('content')
    </div>
  </main>

  @hasSection('sidebar')
    <aside class="sidebar">
      @yield('sidebar')
    </aside>
  @endif

@include('partials.footer')
