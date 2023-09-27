<footer class="content-info spacing-outer bg-primary text-white py-4 py-md-5">
  <div class="container container--wide">
    <div class="row">
      @php(dynamic_sidebar('sidebar-footer'))
    </div>

    <div class="bg-light">
      @if (has_nav_menu('credits_navigation'))
        <div class="d-flex justify-content-center">
          @include('partials.navigation', ['nav_menu' => 'credits_navigation'])
        </div>
      @endif
    </div>
  </div>
</footer>
