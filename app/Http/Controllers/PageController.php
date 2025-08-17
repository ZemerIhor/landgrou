<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Privacy Policy page
     */
    public function privacyPolicy(): Response
    {
        return response('Privacy Policy - Coming Soon', 200);
    }

    /**
     * Terms of Service page
     */
    public function terms(): Response
    {
        return response('Terms of Service - Coming Soon', 200);
    }
}
