<time class="updated small" datetime="{{ get_post_time('c', true) }}">
  {{ get_the_date() }}
</time>

<p class="byline author vcard small">
  <span>{{ __('By', 'sage') }}</span>
  <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
    {{ get_the_author() }}
  </a>
</p>
