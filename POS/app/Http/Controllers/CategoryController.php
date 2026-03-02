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
}



