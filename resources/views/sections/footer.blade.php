<footer class="content-info">

  <div class="content-info__widgets bg-primary py-md-5 py-4 text-white">
    <div class="has-global-padding is-layout-constrained">
      <div class="alignwide">
        <div class="row">
          @php(dynamic_sidebar('sidebar-footer'))
        </div>
      </div>
    </div>
  </div>

  <div class="content-info__credits bg-light py-2">
    <div class="has-global-padding is-layout-constrained">
      <div class="alignwide">
        @includeWhen(has_nav_menu('credits_navigation'), 'partials.navigation-credits')
      </div>
    </div>
  </div>

</footer>
