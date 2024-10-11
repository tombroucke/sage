<x-button
  data-bs-toggle="modal"
  data-bs-target="#{{ $target }}"
  {{ $attributes }}
  theme="{{ $theme ?? 'primary' }}"
  type="button"
  tag="button"
>
  {{ $slot }}
</x-button>
