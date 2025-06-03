<?php

namespace App\Http\Controllers;

use App\Models\Gallery; // Assuming you have a Gallery model
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Show the gallery
    public function index()
    {
        // Fetch gallery items from the database (assuming a model called Gallery)
        $gallery = Gallery::all(); // Adjust query as necessary for your needs

        // Pass the gallery data to the view
        return view('website.gallery', compact('gallery'));
    }
}
