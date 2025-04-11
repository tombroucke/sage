@if ($inactiveLanguages->isNotEmpty())
  <div class="dropdown">
    <button
      class="btn btn-secondary dropdown-toggle"
      data-bs-toggle="dropdown"
      type="button"
      aria-expanded="false"
    >
      {!! $activeLanguage->native_name !!}
    </button>
    <ul class="dropdown-menu">
      @foreach ($inactiveLanguages as $inactiveLanguage)
        <li>
          <a
            class="dropdown-item"
            href="{{ $inactiveLanguage->url }}"
          >
            {{ $inactiveLanguage->native_name }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>
@endif
