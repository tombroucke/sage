<?php

namespace App\View\Composers;

use Illuminate\Support\Collection;
use Roots\Acorn\View\Composer;

class LanguageSwitcher extends Composer
{
    /**
     * Array of languages
     *
     * @var Collection
     */
    private $languages;

    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        'partials.language-switcher',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'activeLanguage' => $this->activeLanguage(),
            'inactiveLanguages' => $this->inactiveLanguages(),
        ];
    }

    /**
     * Get active language
     *
     * @return object The active language object
     */
    public function activeLanguage(): ?object
    {
        return $this->languages()->first(function ($language) {
            return $language->active;
        });
    }

    /**
     * Get active language
     *
     * @return array Array of language objects
     */
    public function inactiveLanguages(): Collection
    {
        return $this->languages()->filter(function ($language) {
            return ! $language->active;
        });
    }

    /**
     * Get WPML languages
     */
    private function languages(): Collection
    {
        if ($this->languages) {
            return $this->languages;
        }

        if (! function_exists('pll_the_languages') && ! function_exists('icl_get_languages')) {
            return collect();
        }

        if (function_exists('pll_the_languages')) {
            $languages = collect(pll_the_languages(['raw' => 1]))
                ->map(function ($language) {
                    $language['active'] = $language['current_lang'];
                    $language['native_name'] = $language['name'];

                    return $language;
                });
        } elseif (function_exists('icl_get_languages')) {
            $languages = collect(array_reverse(icl_get_languages('skip_missing=0&orderby=KEY&order=DIR')));
        }

        $this->languages = $languages->map(function ($language) {
            return (object) $language;
        });

        return $this->languages;
    }
}
