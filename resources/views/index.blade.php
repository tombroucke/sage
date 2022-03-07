@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())
    @include('forms.search')
  @endif

  @while(have_posts()) @php(the_post())
    @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
  @endwhile

@endsection

@section('sidebar')
  @include('sections.sidebar')
@endsection
