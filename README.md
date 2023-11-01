This is a starter theme, based on the [roots/sage](https://github.com/roots/sage) starter theme

# Installation

## Install composer packages in Bedrock or Sage root directory
```sh
  composer require log1x/navi tombroucke/otomaties-sage-helper
```

## Publish bootstrap components
```sh
  wp acorn vendor:publish --tag="Bootstrap components"
```

### Find & Replace
- %devurl% (without https://)
- %client_name%
- %themename%
- %mu-plugin-namespace%

# Features
## Bootstrap
- Bootstrap is loaded by default. You can comment out components & helpers in resources/styles/config/bootstrap to decrease build time.
- Custom pagination (`@include('partials.pagination')`)
- Breadcrums (`@include('partials.breadcrumb')`)

## PurgeCSS
- Add css classes to `purge-safelist.cjs` to whitelist

## WPML
- Add `@include('partials.language-switcher')` to have a WPML language switcher appear

## Built-in support for headroom.js
- All you need to do is add styling for the headroom classes (`banner--not-top`, `banner--unpinned`, ...)

[WickyNilliams/headroom.js](https://github.com/WickyNilliams/headroom.js)

## Custom block styles
- In `resources/scripts/editor.js`, we add a 'Lead' style to the `core/paragraph` block. Use `.is-style-lead` to add styling.

## Ray directive
You can use the `@ray($somevariable)` directive to output to your [Ray](https://spatie.be/products/ray) console

# Customization

## Blocks
### Default blocks from Otomaties sage helper
Default blocks (accordion, cards, gallery, hero, ...) can be easily added from [Otomaties sage helper](https://github.com/tombroucke/otomaties-sage-helper) e.g.:
```sh
wp acorn vendor:publish --tag="Otomaties block Buttons"
```
- .js files in resources/scripts/blocks will be dynamically imported if there is a block matching the name. E.g. `resources/views/blocks/image-content.blade.php` > `resources/scripts/blocks/image-content.js`
- .scss files in resources/styles/blocks will be automatically enqueued in case there is a block with the same name (without namespace). If you want to enqueue a block style for `core/paragraph`, you should create `resources/styles/blocks/paragraph.scss`.

⚠️  After adding scss-files, bud needs to be restarted

### Custom blocks
Custom blocks can be added using [Log1x/acf-composer](https://github.com/Log1x/acf-composer) e.g.:
```sh
wp acorn acf:block MyCustomBlock
```

Views for custom blocks should be wrapped in an `<x-block>` component. E.g:
```php
<x-block :block="$block">
  @if ($items)
    <ul>
      @foreach ($items as $item)
        <li>{{ $item['item'] }}</li>
      @endforeach
    </ul>
  @else
    <p>{{ $block->preview ? 'Add an item...' : 'No items found!' }}</p>
  @endif

  <div>
    <InnerBlocks />
  </div>
</x-block>
```

See also [ACF Builder Cheatsheet](https://github.com/Log1x/acf-builder-cheatsheet)

You can add styles for your block in `resources/styles/blocks/my-block.scss`. These will automatically be enqueue by our theme. Restart bud after adding the style. If you need bootstrap variable, mixins etc.:
```css
@import 'bootstrap/scss/mixins';
@import 'bootstrap/scss/functions';
@import './../config/variables';
@import 'bootstrap/scss/variables';
```

## Google Fonts
0. Install [Laravel Google Fonts](https://github.com/spatie/laravel-google-fonts), should already be installed when using [https://github.com/tombroucke/bedrock](https://github.com/tombroucke/bedrock)
1. Replace font in `config/google-fonts.php`
2. Add font in head (both frontend and admin):
```php
add_action('admin_head', function () {
    echo app(\Spatie\GoogleFonts\GoogleFonts::class)->load()->toHtml();
});

add_action('wp_head', function () {
    echo app(\Spatie\GoogleFonts\GoogleFonts::class)->load()->toHtml();
});
```

## Theme.json
### Container
There are 2 widths for containers: contentSize (768px) and wideSize (1320px). These can be changed from the theme.json

### Colors
Colors defined in `resources/styles/config/_variables.scss` should be copied over to theme.json (`settings.color.pallette`). There is a ThemeJson facade to extract the colors. 

**Get a <key, value> list of all theme colors in PHP:**
```php
ThemeJson::colors()->pluck('name', 'slug');
```

## Navigation
- This starter theme uses [Log1x/navi](https://github.com/Log1x/navi). The navigation is built in `app/View/Composers/Navigation.php`.
- You can add bootstrap button classes to menu items (e.g. `btn btn-primary`) to style them as buttons
- You can add fontawesome classes to add icons (e.g. `fas-envelope`)
- `resources/scripts/components/header.js` will listen to click events on a `.menu-item--has-submenu` element, and toggle the `menu-item--open` class on this element. It will also remove the `menu-item--open` class from every other element 

### Mobile nav
- `resources/scripts/components/header.js` will listen to click events on a `.navbar-toggler` element, and toggle the `primary-nav-open` class on the body element.

## Google maps
If you're using Google Maps, you can add the GOOGLE_MAPS_KEY variable to your .env file 

# Snippets

## SVG logo
File should be in `resources/icons/logoname.svg`
```
<x-icon-logoname width="200" height="100" />
```

## Get a list of fontawesome icons in a list
```php
// app/Providers/ThemeServiceProvider.php
$this->app->bind('icons', function() {
    return Cache::rememberForever('fontawesome-icons', function () {
        $icons = [];
        $sets = app()->make('BladeUI\Icons\Factory')->all();
        foreach ($sets as $setname => $set) {
            if (strpos($setname, 'fontawesome') === false) {
                continue;
            }

            $niceSetName = str_replace('fontawesome-', '', $setname);
            foreach ($set['paths'] as $path) {
                $files = glob($path . '/*.svg');
                foreach ($files as $file) {
                    $iconBasename = basename($file, '.svg');
                    $iconName = $set['prefix'] . '-'. $iconBasename;
                    $icons[$iconName] = "$iconBasename $niceSetName";
                }
            }
        }
        return $icons;
    });
});


// app/Blocks/BlockWithIcons.php
...
->addSelect('icon', [
    'label' => __('Icon', 'sage'),
    'choices' => app()->make('icons'),
    'default_value' => 'fas-star',
])
...

```
