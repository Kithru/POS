<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    // Show Add Item Page
    public function create()
    {
        $items = Item::orderBy('item_id', 'desc')->get();
        return view('item.add_item', compact('items'));
    }

    // Store Item
    public function store(Request $request)
    {
        $request->validate([
            'item_name'     => 'required|max:255',
            'currency_type' => 'required',
            'description'   => 'nullable',
            'price'         => 'required|numeric',
            'quantity'      => 'required|numeric',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'countable'     => 'nullable|integer'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $imageName = $filename . '_' . time() . '.' . $extension;
            $file->storeAs('images/uploads', $imageName);
        }

        Item::create([
            'item_name'      => $request->item_name,
            'currency_type'  => $request->currency_type,
            'description'    => $request->description,
            'price'          => $request->price,
            'quantity'       => $request->quantity,
            'countable'      => $request->countable ?? 1,
            'image'          => $imageName,
            'added_date'     => now(),
            'added_by'       => Auth::id(),
            'modified_date'  => null,
            'modified_by'    => null
        ]);

        return redirect()->route('item.add')->with('success', 'Item Added Successfully');
    }
}