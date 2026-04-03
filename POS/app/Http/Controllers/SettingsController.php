<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Illuminate\Http\Request;

class SettingsController extends Controller {
    
    public function index(){
        $prefectures = Prefecture::orderBy('prefecture_id', 'asc')->get();
        return view('settings.prefecture', compact('prefectures'));
    }

    public function save(Request $request)
{
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
}
