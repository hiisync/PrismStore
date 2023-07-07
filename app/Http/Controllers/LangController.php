<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;

class LangController extends Controller
{
    /**
     * Change the language of the application
     */
    public function index($locale): RedirectResponse
    {
        $langDirs = array_map('basename', File::directories(base_path('lang')));

        if (! in_array($locale, $langDirs)) {
            abort(404);
        }

        app()->setLocale($locale);
        session()->put('locale', $locale);

        if (url()->previous()) {
            return redirect()->back();
        } else {
            return redirect()->route('home');
        }
    }
}
