@if(!empty($socialMedia))
  <ul class="social-media d-flex list-unstyled m-0">
    @foreach($socialMedia as $socialMedium)
      <li><a class="btn btn-primary" href="{{ $socialMedium['link'] }}" target="_blank"><x-icon.brand name="{{ $socialMedium['icon'] }}"></x-icon.brand></a></li>
    @endforeach
  </ul>
@endif
