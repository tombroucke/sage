<x-breadcrumb>
  @foreach($breadcrumbItems as $breadcrumbItem)
    @if(array_key_exists('url', $breadcrumbItem))
      <x-breadcrumb.item href="{{ $breadcrumbItem['url'] }}">
        {!! $breadcrumbItem['label'] !!}
      </x-breadcrumb.item>
    @else
      <x-breadcrumb.item>
        {!! $breadcrumbItem['label'] !!}
      </x-breadcrumb.item>
    @endif
  @endforeach
</x-breadcrumb>
