<header>
  <h1 class="entry-title">
    {!! $title !!}
  </h1>

  @include('partials.entry-meta')
</header>

@php(the_content())
