@if ($navigation)

  <button
    class="navbar-toggler d-lg-none btn btn-sm p-0"
    aria-label="{{ __('Toggle navigation', 'sage') }}"
  >
    <div>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </button>

  <nav class="navigation-primary">
    <ul class="d-flex list-unstyled m-0 gap-3">
      @foreach ($navigation as $item)
        <li @class([
            'menu-item',
            'menu-item--active' => $item->active,
            'menu-item--has-submenu' => $item->children,
        ])>
          @if (isset($item->buttonTheme))
            <x-button
              :href="$item->url"
              :theme="$item->buttonTheme"
              :target="$item->target"
            >
              {!! $item->label !!}
            </x-button>
          @else
            <a
              href="{{ $item->url }}"
              target="{{ $item->target }}"
            >
              {!! $item->label !!}
            </a>
          @endif

          @includeWhen($item->children, 'partials.navigation-children', ['children' => $item->children])
        </li>
      @endforeach
    </ul>
  </nav>

@endif
