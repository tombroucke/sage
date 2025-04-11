This is a starter theme, based on the [roots/sage](https://github.com/roots/sage) starter theme

# Installation

## Install composer packages in Bedrock or Sage root directory

```sh
  composer require log1x/navi tombroucke/otomaties-sage-helper
```

## Add facades to composer.json

```json
"extra": {
  "acorn": {
    "aliases": {
      "Post": "App\\Facades\\Post",
      "ThemeJson": "App\\Facades\\ThemeJson"
    }
  }
},
```

### Find & Replace

- %devurl% (without https://)
- %client_name%
- %themename%
- %mu-plugin-namespace%

# Features

## Bootstrap

- Bootstrap is loaded by default. You should comment out components & helpers in resources/styles/config/bootstrap to decrease build time / filesize.
- Custom pagination (`@include('partials.pagination')`)
- Breadcrumb (`@include('partials.breadcrumb')`)
- Some components might not be rendered correctly (missing styles), this could be fixed by
  - uncommenting the component in `resources/styles/config/bootstrap/components.scss` or `resources/styles/config/bootstrap/helpers.scss`.
  - enqueuing the modal styles by uncommenting `bundle('modal')->enqueue()` in `app/setup.php`

## PurgeCSS

Add css classes to `purgecss-safelist.js` to whitelist
Add css classes to `purgecss-blocklist.js` to block

## WPML

Add `@include('partials.language-switcher')` to have a WPML language switcher appear

## Built-in support for headroom.js

All you need to do is add styling for the headroom classes (`banner--not-top`, `banner--unpinned`, ...)

[WickyNilliams/headroom.js](https://github.com/WickyNilliams/headroom.js)

## Custom block styles

In `resources/scripts/editor.js`, we add a 'Lead' style to the `core/paragraph` block.

## Custom directives

### @ray(mixed $variable)

Outputs a variable to your [Ray](https://spatie.be/products/ray) console

### @background(string $image)

You can pass an image url, which will be added as an inline style background-image.

### @shortcode('[shortcode]')

### @year

Will render the current year

### @preview($block)

Content of this block will only be rendered in the admin interface

### @echoWhen(bool $condition, string $markup)

# Customization

## Blocks

### Default blocks from Otomaties sage helper

Default blocks (accordion, cards, gallery, hero, ...) can be easily added from [Otomaties sage helper](https://github.com/tombroucke/otomaties-sage-helper) e.g.:

```sh
wp acorn vendor:publish --tag="Otomaties block Buttons"
```

- .js files in resources/scripts/blocks will be dynamically imported if there is a block matching the name. E.g. `resources/views/blocks/image-content.blade.php` > `resources/scripts/blocks/image-content.js`
- .scss files in resources/styles/blocks will be automatically enqueued in case there is a block with the same name (without namespace). If you want to enqueue a block style for `core/paragraph`, you should create `resources/styles/blocks/paragraph.scss`.

### Custom blocks

Custom blocks can be added using [Log1x/acf-composer](https://github.com/Log1x/acf-composer) e.g.:

```sh
wp acorn acf:block MyCustomBlock
```

See [ACF Builder Cheatsheet](https://github.com/Log1x/acf-builder-cheatsheet)

You can add styles for your block in `resources/styles/blocks/my-block.scss`. These will automatically be enqueue by our theme. Restart bud after adding the style. If you need bootstrap variables, mixins etc.:

```css
@import 'bootstrap/scss/mixins';
@import 'bootstrap/scss/functions';
@import './../config/variables';
@import 'bootstrap/scss/variables';
```

## Google Fonts

0. Install [Laravel Webfonts](https://github.com/Log1x/laravel-webfonts)
1. Run `wp acorn webfonts:add`, follow the wizard
2. Add `'fonts': ["@styles/fonts"],` to `bud.config.js` and enqueue this asset in `app/setup.php`

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

File should be in `resources/svg/logoname.svg`

```blade
@svg('logoname', ['height' => '2em'])
{{-- or --}}
<x-icon-logoname height="2em" />
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
