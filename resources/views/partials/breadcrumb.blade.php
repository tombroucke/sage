<x-breadcrumb>
  @foreach ($breadcrumbItems as $breadcrumbItem)
    <x-breadcrumb.item :href="$breadcrumbItem['url'] ?? false">
      {!! $breadcrumbItem['label'] !!}
    </x-breadcrumb.item>
  @endforeach
</x-breadcrumb>
