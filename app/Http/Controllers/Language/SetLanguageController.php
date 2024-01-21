<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SetLanguageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $locale)
    {
        auth()->user()->update(['locale' => $locale]);
        session()->put('locale', $locale);

        // Redirect back or to a specific route
        return redirect()->back();
    }
}
