<?php

namespace App\Http\Controllers;

use App\Models\Prefecture;
use Illuminate\Http\Request;

class SettingsController extends Controller {
    
    public function index(){
        $prefectures = Prefecture::orderBy('prefecture_id', 'asc')->get();
        return view('settings.prefecture', compact('prefectures'));
    }

    public function save(Request $request){
    $ids = $request->input('id', []);
    $names = $request->input('prefecture', []);
    $amounts = $request->input('amount', []);

    foreach ($names as $key => $name) {

        // Remove spaces + skip empty values
        $name = trim($name);

        if ($name === '') {
            continue;
        }

        $amount = isset($amounts[$key]) ? (float) $amounts[$key] : 0;
        $id = $ids[$key] ?? null;

        if (!empty($id)) {

            Prefecture::where('prefecture_id', $id)->update([
                'prefecture_name' => $name,
                'amount' => $amount,
                'updated_at' => now()
            ]);

        } else {

            Prefecture::create([
                'prefecture_name' => $name,
                'amount' => $amount,
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
