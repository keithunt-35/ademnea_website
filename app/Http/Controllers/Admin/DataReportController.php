<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hive;
use App\Models\Farm;
use App\Models\Bee;

class DataReportController extends Controller
{
    public function index()
    {
        $hive_id = Hive::where('farm_id', session('farm_id'))->first()->id ?? 'No Hive';
        return view('admin.datareports.index', compact('hive_id'));
    }
    
}
