@if ($navigation)
  <div class="d-flex justify-content-end">
    <nav class="navigation-top">
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
  </div>
@endif
