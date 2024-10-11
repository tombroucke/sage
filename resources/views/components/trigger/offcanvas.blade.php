<x-button
  data-bs-toggle="offcanvas"
  data-bs-target="{{ $target }}"
  {{ $attributes }}
  theme="{{ $theme ?? 'primary' }}"
  type="button"
  aria-controls="{{ $target }}"
>
  {{ $slot }}
</x-button>
