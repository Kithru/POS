<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Illuminate\Http\Request;

class SettingsController extends Controller {
    
    public function index(){
        $prefectures = Prefecture::all();
        return view('settings.prefecture', compact('prefectures'));
    }

    public function save(Request $request){
        $ids = $request->input('id', []);
        $names = $request->input('prefecture', []);
        $amounts = $request->input('amount', []);

        foreach ($names as $key => $name) {

            // UPDATE
            if (!empty($ids[$key])) {

                Prefecture::where('prefecture_id', $ids[$key])
                    ->update([
                        'prefecture_name' => $name,
                        'amount' => $amounts[$key],
                        'updated_at' => now()
                    ]);

            } 
            // INSERT
            else {

                Prefecture::create([
                    'prefecture_name' => $name,
                    'amount' => $amounts[$key],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return redirect()->route('prefecture.index')
            ->with('success', 'Prefecture saved successfully.');
    }

    public function delete($id){
        Prefecture::where('prefecture_id', $id)->delete();

        return redirect()->route('prefecture.index')
            ->with('success', 'Prefecture deleted successfully.');
    }
}