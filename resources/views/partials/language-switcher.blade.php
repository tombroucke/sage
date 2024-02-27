@if (!empty($inactiveLanguages))
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle text-uppercase" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      {!! $activeLanguage->native_name !!}
    </button>
    <ul class="dropdown-menu">
      @foreach ($inactiveLanguages as $inactiveLanguage)
        <li><a class="dropdown-item text-uppercase" href="{{ $inactiveLanguage->url }}">{{ $inactiveLanguage->native_name }}</a></li>
      @endforeach
    </ul>
  </div>
@endif
