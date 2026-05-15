<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;

class PosController extends Controller {
    
    public function index() {
        $categories = Category::where('status', 1)
            ->orderBy('category_name')
            ->get();

        $items = Item::where('status', 1)
            ->orderBy('added_date', 'desc')
            ->get();

        return view('pos.posview', compact('categories','items'));
    }

    public function getSubcategories($category_id) {
        $subcategories = Subcategory::where('category_id', $category_id)
            ->where('status', 1)
            ->orderBy('subcategory_name')
            ->get();

        return response()->json($subcategories);
    }

    public function getItems(Request $request) {
        $query = Item::query();

        $query->where('status', 1);

        // Category Filter
        if ($request->category_id) {

            $query->where(
                'category_id',
                $request->category_id
            );
        }

        // Subcategory Filter
        if ($request->subcategory_id) {

            $query->where(
                'subcategory_id',
                $request->subcategory_id
            );
        }

        // Search
        if ($request->search) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'item_name',
                    'LIKE',
                    '%' . $request->search . '%'
                );

            });
        }

        $items = $query->latest()->get();

        return response()->json($items);
    }
}
