<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Item;
use App\Models\Currency;

class ItemController extends Controller
{
    public function dashboard() {
        if (!session()->has('user_id')) {
            return redirect('/'); 
        }

        // Categories
        $categoryCount = Category::where('status', 1)->count();
        $subcategoryCount = SubCategory::where('status', 1)->count();

        $totalItems = Item::count();
        $activeItems = Item::where('status', 1)->count();

        $pendingOrders = Order::where('status', 0)->count(); // Pending
        $ongoingOrders = Order::whereIn('status', [1,2])->count(); // Confirmed + Preparing
        $completedOrders = Order::where('status', 3)->count(); // Handed Over

        return view('dashboard', compact(
            'categoryCount',
            'subcategoryCount',
            'totalItems',
            'activeItems',
            'pendingOrders',
            'ongoingOrders',
            'completedOrders'
        )); 
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
            'quantity'         => 'nullable|numeric|min:0',
            'discount'         => 'nullable|numeric|min:0|max:100', // new discount validation
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'countable'        => 'nullable|integer'
        ]);

        $exists = Item::where('item_name', $request->item_name)
                    ->where('subcategory_id', $request->subcategory_id)
                    ->exists();

        if ($exists) {
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Item with this name already exists in the selected subcategory.');
        }

        // Handle image
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $imageName = $filename . '_' . time() . '.' . $extension;
            $file->move(public_path('images/uploads'), $imageName);
        }

        // Generate item code
        $subcategory = SubCategory::find($request->subcategory_id);
        $lastItem = Item::latest('item_id')->first();
        $nextId = $lastItem ? $lastItem->item_id + 1 : 1;
        $itemCode = $subcategory->subcategory_code . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Determine quantity based on countable
        $quantity = $request->countable ? $request->quantity : 0;

        Item::create([
            'item_name'       => $request->item_name,
            'item_code'       => $itemCode,
            'currency'        => $request->currency,
            'category_id'     => $request->category_id,
            'subcategory_id'  => $request->subcategory_id,
            'description'     => $request->description,
            'price'           => $request->price,
            'discount'        => $request->discount ?? 0, // new field
            'quantity'        => $quantity,
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
            'quantity'       => 'nullable|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0|max:100', // new field
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

        $quantity = $request->countable ? $request->quantity : 0;

        $item->update([
            'item_name'      => $request->item_name,
            'currency'       => $request->currency,
            'category_id'    => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'description'    => $request->description,
            'price'          => $request->price,
            'discount'       => $request->discount ?? 0, // update discount
            'quantity'       => $quantity,
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

    // public function getItemsForHome() {
    //     $items = \App\Models\Item::select(
    //                 'items.*',
    //                 'currency.currency_icon'
    //             )
    //             ->leftJoin('currency', 'items.currency', '=', 'currency.id')
    //             ->where('items.status', 1)
    //             ->get();

    //     return view('home', compact('items'));
    // }

    // public function getItemsForHome() {
    //     $items = \App\Models\Item::select(
    //                 'items.*',
    //                 'currency.currency_icon as currency_icon'
    //             )
    //             ->leftJoin('currency', 'items.currency', '=', 'currency.id')
    //             ->where('items.status', 1)
    //             ->get();
    //     $categories = \App\Models\Category::whereHas('items', function($q) {
    //         $q->where('status', 1);
    //     })->get();

    //     return view('home', compact('items', 'categories'));
    // }
    
    public function getItemsForHome(Request $request) {
        $query = Item::select(
                    'items.*',
                    'currency.currency_icon as currency_icon'
                )
                ->leftJoin('currency', 'items.currency', '=', 'currency.id')
                ->where('items.status', 1);

        if ($request->filled('category_id')) {
            $query->where('items.category_id', $request->category_id);
        }
        $items = $query->get();
        $exploreItems = Item::where('status', 1)->get();

        $topItems = Item::where('status', 1)
                        ->orderBy('added_date', 'desc') 
                        ->take(10)
                        ->get();

        $categories = Category::whereHas('items', function($q) {
            $q->where('status', 1);
        })->get();

        return view('home', compact('items', 'topItems', 'exploreItems', 'categories'));
    }


    // public function mainSearch(Request $request){
    //     $query = $request->input('query');

    //     $items = \App\Models\Item::select(
    //                     'items.*',
    //                     'currency.currency_icon as currency_icon'
    //                 )
    //                 ->leftJoin('currency', 'items.currency', '=', 'currency.id')
    //                 ->where('items.item_name', 'like', "%{$query}%")
    //                 ->where('items.status', 1)
    //                 ->get();

    //     return view('home', compact('items'));
    // }

    public function mainSearch(Request $request) {
        $query = $request->input('query');

        $items = Item::select(
                        'items.*',
                        'currency.currency_icon as currency_icon'
                    )
                    ->leftJoin('currency', 'items.currency', '=', 'currency.id')
                    ->where('items.item_name', 'like', "%{$query}%")
                    ->where('items.status', 1)
                    ->get();

        $topItems = Item::where('status', 1)
                        ->orderBy('added_date', 'desc') 
                        ->take(10)
                        ->get();

        $exploreItems = $items;
        $categories = Category::whereHas('items', function($q){
            $q->where('status', 1);
        })->get();

        return view('home', compact('items', 'topItems', 'exploreItems', 'categories'));
    }

    public function itemsByCategory($category_id){
        $items = Item::select(
                        'items.*',
                        'currency.currency_icon as currency_icon'
                    )
                    ->leftJoin('currency', 'items.currency', '=', 'currency.id')
                    ->where('items.status', 1)
                    ->where('items.category_id', $category_id)
                    ->get();

        $topItems = Item::where('status', 1)
                        ->orderBy('added_date', 'desc')
                        ->take(10)
                        ->get();

        $exploreItems = $items;

        $categories = Category::whereHas('items', function($q){
            $q->where('status', 1);
        })->get();

        return view('home', compact('items', 'topItems', 'exploreItems', 'categories'));
    }

    public function categoryLanding() {
        $categories = Category::where('status', 1)->orderBy('category_name')->get();
        return view('landing', compact('categories'));
    }

    public function selectCategory($id) {
        return redirect()->route('home', ['category_id' => $id]);
    }

    
    public function filterItems(Request $request) {
        $query = Item::select('items.*', 'currency.currency_icon as currency_icon')
                    ->leftJoin('currency', 'items.currency', '=', 'currency.id')
                    ->where('items.status', 1);

        // Category filter
        if ($request->filled('category_id') && $request->category_id != 'all') {
            $query->where('items.category_id', $request->category_id);
        }

        // Price filters
        if ($request->filled('min_price')) {
            $query->where('items.price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('items.price', '<=', $request->max_price);
        }

        $items = $query->orderBy('items.price', 'asc')->get();

        if ($request->ajax()) {
            return view('partials.products_grid', compact('items'))->render();
        }

        $topItems = Item::where('status', 1)
                        ->orderBy('added_date', 'desc') 
                        ->take(10)
                        ->get();

        $categories = Category::whereHas('items', function($q){
            $q->where('status', 1);
        })->get();

        return view('home', [
            'items' => $items,             
            'topItems' => $topItems,
            'exploreItems' => $items,
            'categories' => $categories
        ]);
    }

    public function filter(Request $request) {
        $categoryId = $request->input('category_id', 'all');
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', 100000);

        $query = Item::where('status', 1);

        if ($categoryId != 'all') {
            $query->where('category_id', $categoryId);
        }

        $query->whereBetween('price', [$minPrice, $maxPrice]);

        $items = $query->get();

        if ($request->ajax()) {
            return view('partials.products_grid', compact('items'))->render();
        }
        $topItems = Item::where('status', 1)
                        ->orderBy('added_date', 'desc') 
                        ->take(10)
                        ->get();

        $categories = Category::whereHas('items', function($q){
            $q->where('status', 1);
        })->get();

        return view('home', [
            'items' => $items,
            'topItems' => $topItems,
            'exploreItems' => $items,
            'categories' => $categories
        ]);
    }

    public function index(){
        $items = Item::where('status', 1)->get();
        $topItems = Item::where('status', 1)
                        ->orderBy('added_date', 'desc') 
                        ->take(10)
                        ->get();

        $exploreItems = $items;
        $categories = Category::all();

        return view('home', compact('items', 'topItems', 'exploreItems', 'categories'));
    }

}