<?php

namespace App\Http\Controllers;

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
    $scholarship = Scholarship::findOrFail($id);

    // Ensure the view name matches your actual blade file name (no .blade.php)
    $pdf = PDF::loadView('website.pdfgenerator', ['scholarship' => $scholarship]);

   $filename = 'AdEMNEA_Scholarship-Instructions.pdf';


    return $pdf->download($filename);
}

}
