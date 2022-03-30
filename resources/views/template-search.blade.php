{{--
  Template Name: Search
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts())
    @php
      the_post();
    @endphp
    @include('partials.page-header')
    @php get_search_form(); @endphp
  @endwhile
@endsection
