<footer class="content-info">

  <div class="content-info__widgets bg-primary py-md-5 py-4 text-white">
    <div class="spacing-outer">
      <div class="container--wide container">
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
