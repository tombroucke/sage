<?php

/**
 * Theme shortcodes.
 */

namespace App;

add_shortcode('social-media', function () {
    ob_start();
    echo view('partials.social-media');
    return ob_get_clean();
});
