@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())
    <x-alert type="warning">
      {!! __('Sorry, no results were found.', 'sage') !!}
    </x-alert>

    @include('forms.search')
  @endif

  @while(have_posts()) @php(the_post())
    @include('partials.content-search')
  @endwhile

  @include('partials.navigation')
@endsection
