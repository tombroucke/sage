<a class="visually-hidden-focusable" href="#main">
  {{ __('Skip to content') }}
</a>

@include('sections.header')
<div class="spacing-outer">
  <main id="main" class="main">
    @yield('content')
  </main>
</div>

@hasSection('sidebar')
  <aside class="sidebar">
    @yield('sidebar')
  </aside>
@endif

@include('sections.footer')
