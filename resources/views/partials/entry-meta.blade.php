<time
  class="updated small"
  datetime="{{ get_post_time('c', true) }}"
>
  {{ get_the_date() }}
</time>

<p>
  <span>{{ __('By', 'sage') }}</span>
  <a
    class="p-author h-card"
    href="{{ get_author_posts_url(get_the_author_meta('ID')) }}"
  >
    {{ get_the_author() }}
  </a>
</p>
