<x-button
  id="js-trigger-toast-{{ $target }}"
  {{ $attributes }}
  theme="{{ $theme ?? 'primary' }}"
  type="button"
>
  {{ $slot }}
</x-button>
