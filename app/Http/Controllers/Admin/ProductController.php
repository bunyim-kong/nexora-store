<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $products = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%{search}%');
            })

            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })

            ->paginate(12);

            $categories = Category::all();

            return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'category_id'     => 'nullable|exists:categories,id',
            'name'            => 'required|string|max:255',
            'des'             => 'required|string',
            'price'           => 'required|numeric|min:0',
            'stock'           => 'nullable|integer|min:0',
            'quantity'        => 'nullable|numeric|min:0',
            'discount_price'  => 'nullable|numeric|min:0',
            'brand'           => 'nullable|string|max:255',
            'is_best_seller'  => 'nullable|boolean',
            'is_featured'     => 'nullable|boolean',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']). '-' . Str::random(5);
        $validated['is_best_sller'] = $request->boolean('is_best_seller');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/product'), $filename);
            $validated['image'] = 'product/' . $filename;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('sucess', 'You have done creating.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'     => 'nullable|exists:categories,id',
            'name'            => 'required|string|max:255',
            'des'             => 'required|string',
            'price'           => 'required|numeric|min:0',
            'stock'           => 'nullable|integer|min:0',
            'quantity'        => 'nullable|numeric|min:0',
            'discount_price'  => 'nullable|numeric|min:0',
            'brand'           => 'nullable|string|max:255',
            'is_best_seller'  => 'nullable|boolean',
            'is_featured'     => 'nullable|boolean',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['is_best_seller'] = $request->boolean('is_best_seller');
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('images/product/' . $product->image))) {
                unlink(public_path('images/product/' . $product->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/product'), $filename);
            $validated['image'] = 'product/' . $filename;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        if ($product->image && file_exists(public_path('images/product/' . $product->image))) {
            unlink(public_path('images/product/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
