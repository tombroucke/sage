<?php

namespace App\View\Composers;

// TODO: replace FunctionalityPluginNamespace
use FunctionalityPluginNamespace\Facades\SocialMedia as SocialMediaFacade;
use Roots\Acorn\View\Composer;

class SocialMedia extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var string[]
     */
    protected static $views = [
        'partials.social-media',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'channels' => SocialMediaFacade::channels()
                ->map(function ($channel, $key) {
                    $channel['icon'] = str_replace('facebook', 'facebook-f', $channel['icon']);

                    return $channel;
                })
                ->sortBy(function ($channel) {
                    return $channel['label'];
                }),
        ];
    }
}
