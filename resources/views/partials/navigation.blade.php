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
  @if ($menuName === 'primary')
    <button class="navbar-toggler d-lg-none btn btn-sm p-0 position-absolute" aria-label="{{ __('Toggle navigation', 'sage') }}">
      <div>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </button>
  @endif
@endif
