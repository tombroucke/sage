<form
  class="search-form"
  role="search"
  method="get"
  action="{{ home_url('/') }}"
>
  <x-input-group>
    <label
      class="visually-hidden-focusable"
      for="s"
    >
      {{ _x('Search for:', 'label', 'sage') }}
    </label>
    <input
      class="form-control"
      id="s"
      type="search"
      placeholder="{!! esc_attr_x('Search &hellip;', 'placeholder', 'sage') !!}"
      value="{{ get_search_query() }}"
      name="s"
    >
    <input
      class="btn btn-primary"
      type="submit"
      value="{{ esc_attr_x('Search', 'submit button', 'sage') }}"
    >
  </x-input-group>
</form>
