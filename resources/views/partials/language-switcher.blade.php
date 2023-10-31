@if (!empty($inactiveLanguages))
  <ul class="list-unstyled">
    <li class="menu-item menu-item--has-submenu menu-item--language-switcher">
      <span>
        {!! $activeLanguage->native_name !!}
      </span>
      <ul class="submenu list-unstyled">
        @foreach ($inactiveLanguages as $inactiveLanguage)
          <li class="submenu-item">
            <a href="{{ $inactiveLanguage->url }}" title="{{ $inactiveLanguage->native_name }}">{{ $inactiveLanguage->native_name }}</a>
          </li>
        @endforeach
      </ul>
    </li>
  </ul>
@endif
