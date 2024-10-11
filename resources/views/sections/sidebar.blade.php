@if (is_active_sidebar('sidebar-primary'))
  <div
    class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"
    style="flex-basis:33%;"
  >
    @php(dynamic_sidebar('sidebar-primary'))
  </div>
@endif
