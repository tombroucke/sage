<?php

namespace App\View\Composers;

use BrandonBranda\Facades\SocialMedia as SocialMediaFacade;
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

    public function socialMediaChannels()
    {
        $order = ['linkedin', 'instagram', 'facebook'];

        return SocialMediaFacade::channels()
            ->map(function ($channel, $key) {
                // $channel['icon'] = str_replace('facebook', 'facebook-f', $channel['icon']);

                return $channel;
            })
            ->sortBy(function ($channel, $key) use ($order) {
                $pos = array_search($key, $order);

                return $pos === false
                    ? count($order)
                    : $pos;
            });
    }
}
