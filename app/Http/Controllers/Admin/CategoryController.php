<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'des' => ['required', 'string'],
            'image_path' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/category'), $filename);
            $validated['image_path'] = $filename;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category have done creating.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'des' => ['required', 'string'],
            'image_path' => ['nullable', 'image', 'max:2048'],
        ]); 

        $validated ['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image_path')) {
            if ($category->image_path && file_exists(public_path('images/category/' . $category->image_path))) {
                unlink(public_path('images/category/' . $category->image_path));
            }

            $file = $request->file('image_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/category'), $filename);
            $validated['image_path'] = $filename;
        }

        Category::update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category have done updating.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        if ($category->image_path && file_exists(public_path('images/category/' . $category->image_path))) {
            unlink(public_path('images/category/' . $category->image_path));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category have done deleting.');
    }
}
