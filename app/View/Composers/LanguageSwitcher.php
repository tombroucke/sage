<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class LanguageSwitcher extends Composer
{
    /**
     * Array of WPML languages
     *
     * @var string[]
     */
    private $languages = [];

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
        $activeLanguages = array_filter($this->languages(), function ($language) {
            return $language->active;
        });
        return !empty($activeLanguages) ? reset($activeLanguages) : null;
    }

    /**
     * Get active language
     *
     * @return array Array of language objects
     */
    public function inactiveLanguages(): array
    {
        $inactiveLanguages = array_filter($this->languages(), function ($language) {
            return !$language->active;
        });
        return $inactiveLanguages;
    }

    /**
     * Get WPML languages
     *
     * @return array
     */
    private function languages(): array
    {
        if (!$this->languages && function_exists('icl_get_languages')) {
            $this->languages = array_reverse(icl_get_languages('skip_missing=0&orderby=KEY&order=DIR'));
        }

        // Return object instead of array
        return array_map(function ($language) {
            return (object)$language;
        }, $this->languages);
    }
}
