<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    /**
     * Test product route
     */
    public function testProduct(string $slug): JsonResponse
    {
        return response()->json([
            'message' => 'Route works!',
            'slug' => $slug,
            'url' => request()->url(),
            'middleware_executed' => true,
            'locale' => app()->getLocale(),
            'all_locales' => config('app.supported_locales', ['en', 'uk']),
            'timestamp' => now()->toISOString()
        ]);
    }
}
