<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Illuminate\Support\Str;
use App\Models\Currency;
use App\Models\Category;
use App\Models\SubCategory;

class ItemController extends Controller
{
    public function dashboard(){
        
        if (!session()->has('user_id')) {
            return redirect('/'); 
        }

        $categoryCount = Category::where('status', 1)->count();         
        $subcategoryCount = SubCategory::where('status', 1)->count();   
        $totalItems = Item::count();                                     
        $activeItems = Item::where('status', 1)->count();               
        return view('dashboard', compact('categoryCount', 'subcategoryCount', 'totalItems', 'activeItems'));
    }    

    // Show Add Item Page
    public function create() {
        $items = Item::orderBy('item_id', 'asc')->paginate(10);
        $currencies = Currency::orderBy('currency')->get(); 
        $categories = Category::orderBy('category_name')->get();

        return view('item.add_item', compact('items', 'currencies', 'categories'));
    }

    // Store Item
    public function store(Request $request) {

        $request->validate([
            'item_name'        => 'required|max:255',
            'currency'         => 'required',
            'category_id'      => 'required|exists:categories,category_id',
            'subcategory_id'   => 'required|exists:subcategories,subcategory_id',
            'description'      => 'nullable',
            'price'            => 'required|numeric',
            'quantity'         => 'required|numeric',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'countable'        => 'nullable|integer'
        ]);

        // Check for duplicate in same subcategory
        $exists = Item::where('item_name', $request->item_name)
                    ->where('subcategory_id', $request->subcategory_id)
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


        $subcategory = SubCategory::find($request->subcategory_id);
        if(!$subcategory) {
            return redirect()->back()->withInput()->with('error', 'Invalid subcategory.');
        }
        $lastItem = Item::latest('item_id')->first();
        $nextId = $lastItem ? $lastItem->item_id + 1 : 1;
        $itemCode = $subcategory->subcategory_code . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        Item::create([
            'item_name'       => $request->item_name,
            'item_code'       => $itemCode,
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
    
    public function manage(Request $request) {
        $query = Item::with(['category','subcategory','currencyRel']);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->subcategory_id) {
            $query->where('subcategory_id', $request->subcategory_id);
        }
        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $items = $query->orderBy('item_id', 'desc')->paginate(10);
        $items->appends($request->all()); 

        $categories = Category::where('status', 1)->get();
        $subcategories = SubCategory::where('status', 1)
            ->when($request->category_id, function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->get();

        return view('item.item_manage', compact('items', 'categories', 'subcategories'));
    }


    public function activate($id) {
        $item = Item::findOrFail($id);

        $item->status = 1;
        $item->modified_date = now();
        $item->save();
        return redirect()->route('item.manage')
        ->with('success','Item Activated Successfully');
    }


    public function deactivate($id) {
        $item = Item::findOrFail($id);

        $item->status = 0;
        $item->modified_date = now();
        $item->save();
        return redirect()->route('item.manage')
        ->with('success','Item Deactivated Successfully');
    }

    // Show Edit Page
    public function edit($id) {
        $item = Item::findOrFail($id);

        $currencies = Currency::orderBy('currency')->get();
        $categories = Category::orderBy('category_name')->get();

        $subcategories = SubCategory::where('category_id', $item->category_id)
            ->where('status',1)
            ->orderBy('subcategory_name')
            ->get();

        return view('item.edit_item', compact(
            'item',
            'currencies',
            'categories',
            'subcategories'
        ));
    }

    // Update Item

    public function update(Request $request, $id){
        $item = Item::findOrFail($id);

        $request->validate([
               'item_name' => ['required','max:255',
                Rule::unique('items')->where(function ($query) use ($request) {
                    return $query->where('subcategory_id', $request->subcategory_id);
                })->ignore($item->item_id, 'item_id')
            ],
            'currency'       => 'required',
            'category_id'    => 'required',
            'subcategory_id' => 'required',
            'price'          => 'required|numeric',
            'quantity'       => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'         => 'required|in:0,1',
        ]);

        $imageName = $item->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();

            $imageName = $filename.'_'.time().'.'.$extension;

            $file->move(public_path('images/uploads'), $imageName);
        }

        $item->update([
            'item_name'      => $request->item_name,
            'currency'       => $request->currency,
            'category_id'    => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description'    => $request->description,
            'price'          => $request->price,
            'quantity'       => $request->quantity,
            'countable'      => $request->countable ?? 1,
            'status'         => $request->status,
            'image'          => $imageName,
            'modified_date'  => now(),
            'modified_by'    => session('user_id')
        ]);

        return redirect()->route('item.manage')
                        ->with('success','Item Updated Successfully');
    }


    public function viewItems(Request $request) {

        $categories = Category::where('status', 1)->orderBy('category_name')->get();
        $subcategories = SubCategory::where('status', 1)
            ->when($request->category_id, function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->orderBy('subcategory_name')
            ->get();

        $query = Item::with(['category', 'subcategory']);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->orderBy('item_name')->paginate(10);
        $items->appends($request->all());

        return view('item.view_items', compact('categories', 'subcategories', 'items'));
    }

    public function getItemsForHome() {
        $items = \App\Models\Item::select(
                    'items.*',
                    'currency.currency_icon'
                )
                ->leftJoin('currency', 'items.currency', '=', 'currency.id')
                ->where('items.status', 1)
                ->get();

        return view('home', compact('items'));
    }

    public function mainSearch(Request $request){
        $query = $request->input('query');

        $items = \App\Models\Item::select(
                        'items.*',
                        'currency.currency_icon as currency_icon'
                    )
                    ->leftJoin('currency', 'items.currency', '=', 'currency.id')
                    ->where('items.item_name', 'like', "%{$query}%")
                    ->where('items.status', 1)
                    ->get();

        return view('home', compact('items'));
    }

    public function itemsByCategory($category_id) {
        $items = Item::select(
                        'items.*',
                        'currency.currency_icon as currency_icon'
                    )
                    ->leftJoin('currency', 'items.currency', '=', 'currency.id')
                    ->where('items.status', 1)
                    ->where('items.category_id', $category_id)
                    ->get();
        $categories = Category::whereHas('items', function($q){
            $q->where('status', 1);
        })->get();

        return view('home', compact('items', 'categories'));
    }

}