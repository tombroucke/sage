<div {{ $attributes->merge(['class' => 'accordion-item']) }}>
  <div
    class="accordion-header"
    id="{{ $headingId }}"
  >
    <h5 class="mb-0">
      <button
        class="accordion-button {{ $show ? '' : 'collapsed' }}"
        data-bs-toggle="collapse"
        data-bs-target="#{{ $id }}"
        type="button"
        aria-expanded="{{ $show ? 'true' : 'false' }}"
        aria-controls="{{ $id }}"
      >
        {{ $heading }}
      </button>
    </h5>
  </div>

  <div
    class="accordion-collapse {{ $show ? 'show' : '' }} collapse"
    id="{{ $id }}"
    data-bs-parent="#{{ $accordionId }}"
    aria-labelledby="{{ $headingId }}"
  >
    <div class="accordion-body">
      {{ $slot }}
    </div>
  </div>
</div>
