<ul class="submenu list-unstyled">
  @foreach ($children as $child)
    <li class="submenu-item {{ $child->classes ?? '' }} {{ $child->active ? 'submenu-item--active' : '' }}">
      <a href="{{ $child->url }}">
        {!! $child->label !!}
      </a>
      @if ($child->children)
        @include('partials.navigation-children', ['children' => $child->children])
      @endif
    </li>
  @endforeach
</ul>