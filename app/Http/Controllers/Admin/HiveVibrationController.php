<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

// use App\Imports\VibrationDataImport;
// use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HiveVibrationController extends Controller
{


public function plot(Request $request){

    $hiveId = $request->query('hive_id');

 $path=public_path('vibrations/vibration.csv');
 
 if (!file_exists($path)) {
    return response()->json(['error' => 'File not found'], 404);
}

 $data=array_map('str_getcsv',file($path));

 $json_data = json_encode($data);

return view('admin.hivegraphs.vibrations', ['data' => $json_data,'hive_id' => $hiveId]);
}


}
