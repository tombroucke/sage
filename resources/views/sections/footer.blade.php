<footer class="content-info">
  <div class="container container--wide">
    <div class="row">
      @php(dynamic_sidebar('sidebar-footer'))
    </div>
  </div>

  <div class="bg-light">
    <div class="container">
      @if (has_nav_menu('credits_navigation'))
        <div class="d-flex justify-content-center">
          @include('partials.navigation', ['nav_menu' => 'credits_navigation'])
        </div>
      @endif
    </div>
  </div>
</footer>
