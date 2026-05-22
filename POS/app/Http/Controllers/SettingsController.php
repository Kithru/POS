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

    ///////////////////////////////////////////////////////////////////////////////////////////

    public function addTable(){
        $tables = TableModel::orderBy('id', 'desc')->paginate(10);
        return view('settings.addtable', compact('tables'));
    }

    public function saveTable(Request $request) {
        $request->validate([
            'table_number'          => 'required|unique:tables,table_number',
            'availability'          => 'required|in:0,1',
            'table_status'          => 'required|in:0,1',
            'reservation_starttime' => 'nullable|date',
            'reservation_endtime'   => 'nullable|date|after:reservation_starttime',
            'max_pax'               => 'required|integer|min:1',
            'min_pax'               => 'required|integer|min:1|lte:max_pax',
        ]);

        TableModel::create([
            'table_number'          => $request->table_number,
            'availability'          => $request->availability,
            'table_status'          => $request->table_status,
            'reservation_starttime' => $request->reservation_starttime,
            'reservation_endtime'   => $request->reservation_endtime,
            'max_pax'               => $request->max_pax,
            'min_pax'               => $request->min_pax,
        ]);

        return redirect()->route('settings.addtable')->with('success', 'Table added successfully');
    }



    public function changeStatus($id){
        $table = Table::findOrFail($id);
        if ($table->table_status == 1) {
            $table->table_status = 0;
        } else {
            $table->table_status = 1;
        }
        $table->save();

        return redirect()->back()->with('success', 'Table status updated successfully.');
    }


}
