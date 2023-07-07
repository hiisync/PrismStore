<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ProductStoreRequest;
use App\Http\Requests\Products\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:see products in admin panel'])->only(['admin']);
        $this->middleware(['permission:create products'])->only(['create', 'store']);
        $this->middleware(['permission:edit products'])->only(['edit', 'update']);
        $this->middleware(['permission:delete products'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::latest()->with('category')
                ->when($request->input('search'), function ($query, $search) {
                    return $query->where('name->en', 'like', '%'.$search.'%')
                        ->orWhere('name->uk', 'like', '%'.$search.'%');
                })
                ->when($request->input('category'), function ($query, $category) {
                    return $query->where('category_id', $category);
                })
                ->paginate(50)
                ->withQueryString(),
            'getLang' => session('locale') ?? config('app.fallback_locale'),
            'categories' => Category::all(),
            'user' => Auth::user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Products/Create', [
            'categories' => Category::all(),
            'locale' => session('locale') ?? config('app.fallback_locale'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        Product::create(
            [
                'name' => [
                    'uk' => $request->input('name_uk'),
                    'en' => $request->input('name_en'),
                ],
                'price' => $request->input('price'),
                'description' => [
                    'uk' => $request->input('description_uk'),
                    'en' => $request->input('description_en'),
                ],
                'category_id' => $request->input('category_id'),
                'image' => $request->file('image')->store('products/images', 'public'),
                'type' => $request->input('type'),
                'command' => $request->input('command'),
                'item' => $request->input('item'),
                'amount' => $request->input('amount'),
            ]
        );

        return redirect()->route('admin.products.admin');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => Category::all(),
            'locale' => session('locale') ?? config('app.fallback_locale'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update(
            [
                'name' => [
                    'uk' => $request->input('name_uk'),
                    'en' => $request->input('name_en'),
                ],
                'price' => $request->input('price'),
                'description' => [
                    'uk' => $request->input('description_uk'),
                    'en' => $request->input('description_en'),
                ],
                'category_id' => $request->input('category_id'),
                'image' => $request->hasFile('image') ? $request->file('image')->store('products/images', 'public') : $product->image,
                'type' => $request->input('type'),
                'command' => $request->input('command'),
                'item' => $request->input('item'),
            ]
        );

        if ($request->hasFile('image')) {
            Storage::delete($product->image);
        }

        return redirect()->route('admin.products.admin');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.admin');
    }

    /**
     * List products on admin page.
     */
    public function admin(Request $request): Response
    {
        return Inertia::render('Admin/Products/Index', [
            'locale' => session('locale') ?? config('app.fallback_locale'),
            'products' => Product::latest()->when($request->input('search'), function ($query, $search) {
                return $query->where('name->uk', 'like', '%'.$search.'%')
                    ->orWhere('name->en', 'like', '%'.$search.'%');
            })
                ->with('category')
                ->paginate(10)
                ->withQueryString(),
        ]);
    }
}
