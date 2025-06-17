<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Scholarship;
use PDF; 

class ScholarshipDisplayController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::all();

        return view('website.scholarshiplayout', compact('scholarships'));
    }

    public function show($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        return view('website.scholarshiplayout', compact('scholarship'));
    }


public function downloadInstructionsPdf($id)
{
    // You can use the ID if each scholarship has its own PDF file (optional)
    $filename = 'AdEMNEA Work Package 2 TASK 2.4 SCHOLARSHIP CALL.pdf';

    $path = storage_path('app/public/scholarship/' . $filename);

    if (!file_exists($path)) {
        abort(404, 'File not found');
    }

    return response()->download($path);
}


}
