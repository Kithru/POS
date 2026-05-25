<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use App\Models\TableModel;
use Illuminate\Http\Request;

class SettingsController extends Controller {
    
    public function index(){
        $prefectures = Prefecture::orderBy('prefecture_id', 'asc')->get();
        return view('settings.prefecture', compact('prefectures'));
    }

    public function save(Request $request) {
    $name = trim($request->name);
    $amount = $request->amount;
    $id = $request->id;

    if ($name === '' || $amount === null) {
        return back()->with('error', 'All fields are required.');
    }

    if (!empty($id)) {
        // UPDATE
        Prefecture::where('prefecture_id', $id)->update([
            'prefecture_name' => $name,
            'amount' => $amount,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Prefecture updated successfully.');
    } else {
        // ADD
        Prefecture::create([
            'prefecture_name' => $name,
            'amount' => $amount,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Prefecture added successfully.');
    }
}
    public function delete($id){
        Prefecture::where('prefecture_id', $id)->delete();
        return redirect()->route('prefecture.index')
            ->with('success', 'Prefecture deleted successfully.');
    }

    /////////////////////////////////////////////////////////////////////////////////////////

    public function addTable() {
        $tables = TableModel::orderBy('id', 'desc')->paginate(10);
        return view('settings.addtable', compact('tables'));
    }

    public function saveTable(Request $request) {
        $request->validate([
            'table_number' => 'required',
            'min_pax' => 'required|integer|min:1',
            'max_pax' => 'required|integer|min:1|gte:min_pax',
        ]);
        if ($request->id) {
            $table = TableModel::findOrFail($request->id);
            $table->update([
                'table_number' => $request->table_number,
                'min_pax' => $request->min_pax,
                'max_pax' => $request->max_pax,
            ]);

            return redirect()->back()->with('success', 'Table updated successfully');
        }
        TableModel::create([
            'table_number' => $request->table_number,
            'min_pax' => $request->min_pax,
            'max_pax' => $request->max_pax,
            'availability' => 1,
            'table_status' => 1,
        ]);

        return redirect()->back()->with('success', 'Table created successfully');
    }



    public function changeStatus($id) {
        $table = TableModel::findOrFail($id);

        $table->table_status = !$table->table_status;
        $table->save();

        return back()->with('success', 'Table status updated successfully.');
    }

    public function changeAvailability($id) {
        $table = TableModel::findOrFail($id);

        $table->availability = !$table->availability;
        $table->save();
        return back()->with('success', 'Table availability updated successfully.');
    }

}
