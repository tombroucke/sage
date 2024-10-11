<div
  {{ $attributes->merge(array_filter($defaultAttributes())) }}
  @if ($background) @background($background) @endif
>
  {{ $slot }}
</div>
