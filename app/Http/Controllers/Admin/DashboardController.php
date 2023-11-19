<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() 
    {
        return view('admin.dashboard.index');
    }

    public function setLocale(Request $request, $locale)
    {
        if (! in_array($locale, ['sq', 'en'])) {
            abort(400);
        }
        session(['locale' => $locale]);

        return redirect()->back();
    }
}