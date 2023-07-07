<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Navigations\NavigationStoreRequest;
use App\Http\Requests\Navigations\NavigationUpdateRequest;
use App\Models\Navigation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NavigationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:see navigations in admin panel'])->only(['index']);
        $this->middleware(['permission:create navigations'])->only(['create', 'store']);
        $this->middleware(['permission:edit navigations'])->only(['edit', 'update']);
        $this->middleware(['permission:delete navigations'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Navigation/Index', [
            'navigations' => Navigation::when($request->input('search'), function ($query, $search) {
                return $query->where('name->uk', 'like', '%'.$search.'%')
                    ->orWhere('name->en', 'like', '%'.$search.'%');
            })
                ->paginate(10)
                ->withQueryString(),
            'locale' => session('locale'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Navigation/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NavigationStoreRequest $request)
    {
        Navigation::create([
            'name' => [
                'uk' => $request->input('name_uk'),
                'en' => $request->input('name_en'),
            ],
            'url' => $request->input('url'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route('admin.navigations.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Navigation $navigation)
    {
        return Inertia::render('Admin/Navigation/Edit', [
            'navigation' => $navigation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NavigationUpdateRequest $request, Navigation $navigation)
    {
        $navigation->update([
            'name' => [
                'uk' => $request->input('name_uk'),
                'en' => $request->input('name_en'),
            ],
            'url' => $request->input('url'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route('admin.navigations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Navigation $navigation)
    {
        $navigation->delete();

        return back();
    }
}
