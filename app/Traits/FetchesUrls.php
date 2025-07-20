<?php

namespace App\Traits;

use Lunar\Models\Url;

trait FetchesUrls
{
    /**
     * The URL model from the slug.
     */
    public ?Url $url = null;

    /**
     * Fetch a url model.
     *
     * @param  string  $slug
     * @param  string  $type
     * @param  array  $eagerLoad
     */
    public function fetchUrl($slug, $elementType, $with = [])
    {
        $locale = app()->getLocale();

        return Url::where('slug', $slug)
            ->where('element_type', $elementType)
            ->whereHas('language', fn($q) => $q->where('code', $locale))
            ->with($with)
            ->first();
    }

}
