@if ($navigation)
  <nav class="navigation-{{ $menuName }}">
    <ul class="d-flex list-unstyled m-0">
      @foreach ($navigation as $item)
        <li class="menu-item {{ $item->classes ?? '' }} {{ $item->active ? 'menu-item--active' : '' }} {{ $item->children ? 'menu-item--has-submenu' : '' }}">
          <a href="{{ $item->url }}">
              {!! $item->label !!}
          </a>
          @if ($item->children)
            @include('partials.navigation-children', ['children' => $item->children])
          @endif
        </li>
      @endforeach
    </ul>
  </nav>
@endif
