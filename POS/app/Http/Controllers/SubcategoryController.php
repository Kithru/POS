<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class SubcategoryController extends Controller
{
    // Show add subcategory form
    public function create()
    {
        $categories = Category::orderBy('category_name', 'asc')->get(); // all categories ascending
        $subcategories = Subcategory::with('category')
                            ->orderBy('subcategory_id', 'asc') 
                            ->paginate(10); 

        return view('category.subcategory_add', compact('categories', 'subcategories'));
    }

    // Store new subcategory
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'category_id' => 'required|exists:categories,category_id', // match database column
            'subcategory_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Check for duplicate subcategory in the same category
        $duplicate = Subcategory::where('category_id', $request->category_id)
            ->where('subcategory_name', $request->subcategory_name)
            ->first();

        if ($duplicate) {
            return redirect()->back()->withErrors(['subcategory_name' => 'This subcategory already exists for the selected category.'])->withInput();
        }

        // Create subcategory with default status = 1
        Subcategory::create([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'description' => $request->description,
            'added_date' => now()->toDateString(),
            'modified_date' => now()->toDateString(),
            'status' => 1, // default active
        ]);

        return redirect()->back()->with('success', 'Subcategory added successfully!');
    }

    public function manage(){
        $subcategories = Subcategory::with('category')
                            ->orderBy('subcategory_id', 'asc')
                            ->paginate(10);

        return view('category.subcategory_manage', compact('subcategories'));
    }
    public function deactivate($id){
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->update([
            'status' => 0,
            'modified_date' => now()
        ]);

        return redirect()->back()->with('success', 'Subcategory deactivated successfully.');
    }

    public function activate($id){
        $subcategory = Subcategory::findOrFail($id);
        $subcategory->update([
            'status' => 1,
            'modified_date' => now()
        ]);

        return redirect()->back()->with('success', 'Subcategory activated successfully.');
    }

    public function edit($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        // Only get active categories (status = 1)
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('category.subcategory_edit', compact('subcategory', 'categories'));
    }

}