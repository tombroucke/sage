@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div @class([
      'wp-block-columns is-layout-flex wp-block-columns-is-layout-flex',
      'alignwide' => is_active_sidebar('sidebar-primary'),
  ])>
    <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
      @if (have_posts())
        @while (have_posts())
          @php(the_post())
          @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
        @endwhile

        @include('partials.pagination')
      @else
        <x-alert type="warning">
          {!! __('Sorry, no results were found.', 'sage') !!}
        </x-alert>
      @endif
    </div>

    @include('sections.sidebar')
  </div>
@endsection
