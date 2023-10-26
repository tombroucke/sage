@extends('layouts.app')

@section('content')

<div class="wp-block-columns {{ is_active_sidebar('sidebar-primary') ? 'alignwide' : '' }} is-layout-flex wp-block-columns-is-layout-flex">
  <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow">
    @while(have_posts()) @php(the_post())
      @includeFirst(['partials.content-single-' . get_post_type(), 'partials.content-single'])
    @endwhile
  </div>

  @include('sections.sidebar')
</div>
@endsection
