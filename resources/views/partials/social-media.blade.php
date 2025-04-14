@if ($socialMediaChannels->isNotEmpty())
  <ul class="social-media d-flex list-unstyled gap-2">
    @foreach ($socialMediaChannels as $socialMediaChannel)
      <li>
        <a
          href="{{ $socialMediaChannel['link'] }}"
          target="_blank"
          aria-label="{{ $socialMediaChannel['label'] }}"
        >
          @svg('fab-' . $socialMediaChannel['icon'], ['width' => '1.2em', 'height' => '1.2em'])
        </a>
      </li>
    @endforeach
  </ul>
@endif
