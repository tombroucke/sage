<?php
namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Traits\Macroable;

class ThemeJson {

    private ?array $themeColors = null;

    use Macroable;

    /**
     * Get the theme colors.
     *
     * @return Collection
     */
    public function colors() : Collection
    {
        if ($this->themeColors) {
            $themeColors = $this->themeColors;
        } elseif (Cache::get('theme_colors')) {
            $themeColors = Cache::get('theme_colors');
        } else {
            $themeJson = json_decode(file_get_contents(app()->basePath('theme.json')), true);
            $themeColors = $themeJson['settings']['color']['palette'] ?? [];
            Cache::put('theme_colors', $themeColors, 60 * 24 * 7);
        }
        $this->themeColors = $themeColors;
        return collect($this->themeColors);
    }

    /**
     * Get hex value of a theme color
     *
     * @param string $colorName
     * @return string|null
     */
    public function getColorValue(string $colorName) : ?string
    {
        $themeColor = $this->colors()->firstWhere('slug', $colorName);
        return $themeColor ? $themeColor['color'] : null;
    }
}
