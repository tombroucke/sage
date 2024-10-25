@extends('layouts.app')

@section('content')
  @while (have_posts())
    @php(the_post())
    @include('partials.page-header')
    @includeFirst(['partials.content-page', 'partials.content'])
  @endwhile

  <x-modal id="my-modal">
    <x-slot name="title">
      Title
    </x-slot>
    Content
    <x-slot name="footer">
      <x-button
        data-bs-dismiss="modal"
        tag="button"
        type="button"
        theme="secondary"
      >Close</x-button>
      <x-button
        tag="button"
        type="button"
        theme="primary"
      >
        Save changes
      </x-button>
    </x-slot>
  </x-modal>

  <!-- Trigger: Modal -->
  <x-trigger.modal
    theme="danger"
    target="my-modal"
  >
    Trigger modal
  </x-trigger.modal>
@endsection
