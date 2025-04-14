<?php

namespace App\Exceptions;

use Exception;

class BlockAssetNotFound extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $asset)
    {
        parent::__construct("Vite asset not found: {$asset}. Try running `npm run build` or `npm run dev`.");
    }
}
