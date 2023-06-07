<?php

namespace App\View\Composers;

use function MuPluginNamespace\Functionality\socialMedia;
// TODO: replace MuPluginNamespace
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
            'socialMedia' => socialMedia(),
        ];
    }
}
