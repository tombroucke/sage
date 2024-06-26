@if ($navigation)
  <nav class="navigation-{{ $menuName }}">
    <ul class="d-flex list-unstyled m-0 gap-3">
      @foreach ($navigation as $item)
        <li class="menu-item {{ $item->classes ?? '' }} {{ $item->active ? 'menu-item--active' : '' }} {{ $item->children ? 'menu-item--has-submenu' : '' }}">
          @if(isset($item->buttonTheme))
            <x-button :href="$item->url" :theme="$item->buttonTheme" :target="$item->target">
              {!! $item->label !!}
            </x-button>
          @else
            <a href="{{ $item->url }}" target="{{ $item->target }}">
                {!! $item->label !!}
            </a>
          @endif
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
