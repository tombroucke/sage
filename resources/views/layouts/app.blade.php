<!doctype html>
<html @php(language_attributes())>

<head>
  <meta charset="utf-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >
  @php(do_action('get_header'))
  @php(wp_head())

  <script>
    const sageVars = @json($sageVars());
  </script>

  @vite($viteAssets)
</head>

<body @php(body_class())>
  @php(wp_body_open())

  <div id="app">
    <a
      class="visually-hidden-focusable"
      href="#main"
    >
      {{ __('Skip to content') }}
    </a>

    @include('sections.header')
    <div class="spacing-outer">
      <main
        class="main"
        id="main"
      >
        @yield('content')
      </main>
    </div>

    @hasSection('sidebar')
      <aside class="sidebar">
        @yield('sidebar')
      </aside>
    @endif

    @include('sections.footer')
  </div>

  @php(do_action('get_footer'))
  @php(wp_footer())
</body>

</html>
