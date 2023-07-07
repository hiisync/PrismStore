<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    // TODO
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => Setting::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {

    }
}
