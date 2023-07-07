<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pages\PageStoreRequest;
use App\Http\Requests\Pages\PageUpdateRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:see pages in admin panel'])->only(['index']);
        $this->middleware(['permission:create pages'])->only(['create', 'store']);
        $this->middleware(['permission:edit pages'])->only(['edit', 'update']);
        $this->middleware(['permission:delete pages'])->only(['destroy']);
    }

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Pages/Index', [
            'pages' => Page::when($request->input('search'), function ($query, $search) {
                return $query->where('name->uk', 'like', '%'.$search.'%')
                    ->orWhere('name->en', 'like', '%'.$search.'%');
            })
                ->paginate(10)
                ->withQueryString(),
            'locale' => session('locale') ?? config('app.fallback_locale'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Pages/Create');
    }

    public function store(PageStoreRequest $request): RedirectResponse
    {
        $request->validate([
            'name_uk' => 'required|string|min:1|max:250',
            'name_en' => 'required|string|min:1|max:250',
            'content_uk' => 'required|string|min:1',
            'content_en' => 'required|string|min:1',
            'description_uk' => 'required|string|min:1',
            'description_en' => 'required|string|min:1',
            'slug' => 'required|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/|unique:pages,slug',
        ]);

        Page::create([
            'name' => [
                'uk' => $request->input('name_uk'),
                'en' => $request->input('name_en'),
            ],
            'content' => [
                'uk' => $request->input('content_uk'),
                'en' => $request->input('content_en'),
            ],
            'description' => [
                'uk' => $request->input('description_uk'),
                'en' => $request->input('description_en'),
            ],
            'slug' => Str::slug($request->input('slug')),
        ]);

        return redirect()->route('admin.pages.index');
    }

    public function edit(Page $page)
    {
        return Inertia::render('Admin/Pages/Edit', [
            'page' => $page,
            'lang' => session('locale') ?? config('app.fallback_locale'),
        ]);
    }

    public function update(Page $page, PageUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'slug' => [
                'required',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('pages')->ignore($page->id),
            ],
        ]);

        $page->update([
            'name' => [
                'uk' => $request->input('name_uk'),
                'en' => $request->input('name_en'),
            ],
            'content' => [
                'uk' => $request->input('content_uk'),
                'en' => $request->input('content_en'),
            ],
            'description' => [
                'uk' => $request->input('description_uk'),
                'en' => $request->input('description_en'),
            ],
            'slug' => Str::slug($request->input('slug')),
        ]);

        return redirect()->route('admin.pages.index');
    }

    public function show(Page $page): Response
    {
        return Inertia::render('Pages/Index', [
            'page' => $page,
            'lang' => session('locale') ?? config('app.fallback_locale'),
        ]);
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return back();
    }
}
