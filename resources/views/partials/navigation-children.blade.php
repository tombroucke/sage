<ul class="submenu list-unstyled">
  @foreach ($children as $child)
    <li @class([
        'submenu-item',
        'submenu-item--active' => $child->active,
        'submenu-item--has-submenu' => $child->children,
    ])>
      <a
        href="{{ $child->url }}"
        target="{{ $child->target }}"
      >
        {!! $child->label !!}
      </a>
      @includeWhen($child->children, 'partials.navigation-children', ['children' => $child->children])
    </li>
  @endforeach
</ul>
