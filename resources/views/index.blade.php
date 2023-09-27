@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="wp-block-columns {{ is_active_sidebar('sidebar-primary') ? 'alignwide' : '' }} is-layout-flex wp-block-columns-is-layout-flex">
    <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
      @if (! have_posts())
        <x-alert type="warning">
          {!! __('Sorry, no results were found.', 'sage') !!}
        </x-alert>

        @include('forms.search')
      @endif

      @while(have_posts()) @php(the_post())
        @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
      @endwhile

      @include('partials.pagination')
    </div>


    @include('sections.sidebar')
  </div>
@endsection
