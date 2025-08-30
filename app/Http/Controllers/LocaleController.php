<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function set($locale)
    {
        $allowed = config('app.available_locales', ['en', 'my']);
        if (in_array($locale, $allowed)) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    }
}
