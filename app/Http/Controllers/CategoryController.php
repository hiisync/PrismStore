<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\CategoryStoreRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:see categories in admin panel');
        $this->middleware('permission:create categories')->only(['create', 'store']);
        $this->middleware('permission:edit categories')->only(['edit', 'update']);
        $this->middleware('permission:delete categories')->only(['destroy']);
    }

    public function index(Request $request)
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => Category::when($request->input('search'), function ($query, $search) {
                return $query->where('name->uk', 'like', '%'.$search.'%')
                    ->orWhere('name->en', 'like', '%'.$search.'%');
            })
                ->paginate(10)
                ->withQueryString(),
            'locale' => session('locale') ?? config('app.fallback_locale'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Categories/Create');
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create([
            'name' => [
                'uk' => $request->input('name_uk'),
                'en' => $request->input('name_en'),
            ],
        ]);

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update([
            'name' => [
                'uk' => $request->input('name_uk'),
                'en' => $request->input('name_en'),
            ],
        ]);

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }
}
