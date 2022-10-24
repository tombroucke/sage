@if(!empty($socialMedia))
  <ul class="social-media d-flex list-unstyled m-0">
    @foreach($socialMedia as $socialMedium)
      <li>
        <a class="btn btn-sm" href="{{ $socialMedium['link'] }}" target="_blank" aria-label="{{ $socialMedium['title'] }}">
          <x-icon :name="'fab-' . $socialMedium['icon']" width="22" height="22"/>
        </a>
      </li>
    @endforeach
  </ul>
@endif
