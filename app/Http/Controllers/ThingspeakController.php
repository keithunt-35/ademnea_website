<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Thingspeak;

class ThingspeakController extends Controller
{
    
    public function index(Request $request){

        $hiveId = $request->query('hive_id');

        // $hiveId = $request->query('hive_id');

        if ($request->ajax()) {
            $data = Thingspeak::query();

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }

            return DataTables::of($data)->addIndexColumn()->make(true);
        }

        $data = Thingspeak::orderBy('created_at', 'desc')->take(10)->get();

        // return view('datanavbar', ['hive_id' => $hive_id]);

        return view('admin.thingspeak.index', compact('data', 'hiveId'));
   

    $data=Thingspeak::orderBy('created_at','desc')->take(10)->get();

    return view('admin.thingspeak.index',compact('data'));
    }


    public function  fetchData(){
        $data=Thingspeak::orderBy('created_at','desc')->take(10)->get();

        return response()->json($data);
    }
}
