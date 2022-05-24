<article @php(post_class())>
  <div class="{{ $containerClass }}">
    <header>
      <h1 class="entry-title">
        {!! $title !!}
      </h1>

      @include('partials.entry-meta')
    </header>

    @php(the_content())
  </div>
</article>
