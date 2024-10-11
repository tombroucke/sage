@unless (empty($pages))
  <x-pagination>
    @foreach ($pages as $page)
      <li @class(['page-item', 'active' => $page['active']])>
        {!! $page['link'] !!}
      </li>
    @endforeach
  </x-pagination>
@endunless
