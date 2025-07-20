<?php

namespace App\Traits;

use Lunar\Models\Url as LunarUrl;

trait FetchesUrls
{
    public function fetchUrl($slug, $elementType, $with = []): ?LunarUrl
    {
        $slugsToCheck = [$slug];
        if (str_ends_with($slug, 'vfv')) {
            $slugsToCheck[] = str_replace('vfv', '', $slug);
        } else {
            $slugsToCheck[] = $slug . 'vfv';
        }

        $query = LunarUrl::where('element_type', $elementType)
            ->whereIn('slug', $slugsToCheck);

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->first();
    }
}
