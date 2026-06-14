<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TableModel;

class PosController extends Controller {
    
    public function index() {
        $categories = Category::where('status', 1)
            ->orderBy('category_name')
            ->get();

        $items = Item::where('status', 1)
            ->orderBy('added_date', 'desc')
            ->get();

         $tables = TableModel::where('availability', 0)
        ->orderBy('table_number', 'asc')
        ->get();

        return view('pos.posview', compact( 'categories','items', 'tables' ));
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

        // Only active items
        $query->where('status', 1);

        // Category filter
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Subcategory filter
        if ($request->subcategory_id) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // Search filter
        if ($request->search) {
            $query->where('item_name', 'LIKE', '%' . $request->search . '%');
        }

        // IMPORTANT: use your custom date column (NOT created_at)
        $items = $query
            ->orderBy('added_date', 'desc')
            ->get();

        return response()->json($items);
    }

    public function pos() {
        $categories = Category::all();
        $items = Item::where('status', 1)->get();
        $tables = TableModel::where('availability', 0)
                    ->orderBy('table_number')
                    ->get();

        return view('pos', compact('categories','items', 'tables'));
    }

  
    public function create() {
        $tables = TableModel::where('availability', 1)->get();
        return view('your-view', compact('tables'));
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {

            $orderCode = 'POS' . now()->format('ymdHis');

            $order = Order::create([
                'order_code' => $orderCode,
                'total_amount' => $request->total_amount,
                'final_amount' => $request->final_amount,
                'order_type' => $request->order_type,
                'payment_status' => $request->payment_status,
                'payment_date' => $request->payment_status == 1 ? now() : null,
                'table_no' => $request->table_no,
                'status' => 1
            ]);

            OrderCustomer::create([
                'order_id' => $order->order_id,
                'order_code' => $orderCode,
                'customer_first_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone
            ]);

            foreach ($request->items as $item) {

                OrderItem::create([
                    'order_id' => $order->order_id,
                    'item_id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'],
                    'final_amount' => $item['price'] * $item['qty'],
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->order_id
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
