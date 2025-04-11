@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @unless (have_posts())
    <x-alert type="warning">
      {!! __('Sorry, but the page you are trying to view does not exist.', 'sage') !!}
    </x-alert>
  @endunless
@endsection
