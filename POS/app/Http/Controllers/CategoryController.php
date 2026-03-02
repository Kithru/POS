<?php

namespace App\Http\Controllers;
use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('category_id','desc')->get();
        return view('category.category_add', compact('categories'));
    }

    // Store new category
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
            'description' => 'nullable|string'
        ]);

        // Create
        Category::create([
            'category_name' => $request->category_name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Category added successfully!');
    }

    // Show Manage Categories page
    public function manage()
    {
        $categories = Category::orderBy('category_id', 'desc')->get();
        return view('category.category_manage', compact('categories'));
    }

    // Show Edit Category page
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.category_edit', compact('category'));
    }

    // Update Category
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => "required|unique:categories,category_name,$id,category_id",
            'description' => 'nullable|string'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name,
            'description' => $request->description,
            'modified_date' => now(),
        ]);

        return redirect()->route('category.manage')->with('success', 'Category updated successfully!');
    }

    // Delete Category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.manage')->with('success', 'Category deleted successfully!');
    }
}



