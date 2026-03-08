<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Currency;
use App\Models\Category;
use App\Models\SubCategory;

class ItemController extends Controller
{
    // Show Add Item Page
    public function create() {
        $items = Item::orderBy('item_id', 'desc')->get();
        $currencies = Currency::orderBy('currency')->get(); 
        $categories = Category::orderBy('category_name')->get();

        return view('item.add_item', compact('items', 'currencies', 'categories'));
    }

    // Store Item
    public function store(Request $request) {
        // Basic validation
        $request->validate([
            'item_name'        => 'required|max:255',
            'currency'         => 'required',
            'category_id'      => 'required|exists:categories,id',
            'subcategory_id'  => 'required|exists:subcategories,id',
            'description'      => 'nullable',
            'price'            => 'required|numeric',
            'quantity'         => 'required|numeric',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'countable'        => 'nullable|integer'
        ]);

        // Check for duplicate in same subcategory
        $exists = Item::where('item_name', $request->item_name)
                    ->where('sub_category_id', $request->sub_category_id)
                    ->exists();

        if ($exists) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Item with this name already exists in the selected subcategory.');
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $imageName = $filename . '_' . time() . '.' . $extension;
            $file->move(public_path('images/uploads'), $imageName);
        }

        Item::create([
            'item_name'       => $request->item_name,
            'currency'        => $request->currency,
            'category_id'     => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description'     => $request->description,
            'price'           => $request->price,
            'quantity'        => $request->quantity,
            'countable'       => $request->countable ?? 1,
            'image'           => $imageName,
            'added_date'      => now(),
            'added_by'        => session('user_id'),
            'modified_date'   => null,
            'modified_by'     => null
        ]);

        return redirect()->route('item.add')->with('success', 'Item Added Successfully');
    }

    public function getSubcategories($category_id) {
        $subcategories = SubCategory::where('category_id', $category_id)
            ->where('status',1)
            ->orderBy('subcategory_name')
            ->get();
        return response()->json($subcategories);
    }
    

}