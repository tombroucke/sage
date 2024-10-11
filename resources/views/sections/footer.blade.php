<footer class="content-info">

  <div class="content-info__widgets bg-primary text-white py-4 py-md-5">
    <div class="spacing-outer">
      <div class="container container--wide">
        <div class="row">
          @php(dynamic_sidebar('sidebar-footer'))
        </div>
      </div>
    </div>
  </div>

  <div class="content-info__credits bg-light py-2">
    <div class="spacing-outer">
      @includeWhen(has_nav_menu('credits_navigation'), 'partials.navigation-credits')
    </div>
  </div>

</footer>
