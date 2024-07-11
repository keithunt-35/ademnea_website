<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vibration;

class HiveVibrationsController extends Controller
{
    public function plot(Request $request)
    {
        $hiveId = $request->query('hive_id');

         // Fetch the latest vibration entry for the given hive_id
         $vibration = Vibration::where('hive_id', $hiveId)
         ->orderBy('created_at', 'desc')
         ->first();

         if (!$vibration) {
            return response()->json(['error' => 'No data found for this hive ID'], 404);
        }

         $path = public_path('hivevibration/' . $vibration->path); 
        $data = array_map('str_getcsv', file($path));
        $json_data = json_encode($data);


        return view('admin.hivegraphs.vibrations', ['hive_id' => $hiveId,'data' => $json_data]);
    }
}