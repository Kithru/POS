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
                        'name' => $name,
                        'amount' => $amounts[$key]
                    ]);

            } 
            // INSERT
            else {

                Prefecture::create([
                    'name' => $name,
                    'amount' => $amounts[$key]
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
