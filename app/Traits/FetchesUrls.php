<?php

namespace App\Traits;

use Lunar\Models\Url as LunarUrl;

trait FetchesUrls
{
    public function fetchUrl($slug, $elementType, $with = []): ?LunarUrl
    {
        $query = LunarUrl::where('element_type', $elementType)
            ->whereIn('slug', [$slug, $slug . 'vfv', str_replace('vfv', '', $slug)]);

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->first();
    }
}
