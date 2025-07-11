<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $publication = Publication::where('name', 'LIKE', "%$keyword%")
                ->orWhere('title', 'LIKE', "%$keyword%")
                ->orWhere('publisher', 'LIKE', "%$keyword%")
                ->orWhere('attachment', 'LIKE', "%$keyword%")
                ->orWhere('year', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $publication = Publication::latest()->paginate($perPage);
        }

        return view('admin.publication.index', compact('publication'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.publication.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

     public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'google_scholar_link' => 'nullable|url|max:500',
            'attachment' => 'nullable|mimes:pdf|max:51200', // PDF file max 50MB
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:51200' // Image file max 50MB
        ]);

        // Handle file uploads
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            // Get the original name of the attachment file
            $attachmentName = $request->file('attachment')->getClientOriginalName();
            // Create the directory if it doesn't exist
            if (!file_exists(public_path('documents/publications'))) {
                mkdir(public_path('documents/publications'), 0777, true);
            }
            // Move the attachment to the 'public/documents/publications' directory
            $request->file('attachment')->move(public_path('documents/publications'), $attachmentName);
            $attachmentPath = 'documents/publications/' . $attachmentName;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Create the directory if it doesn't exist
            if (!file_exists(public_path('images/publications'))) {
                mkdir(public_path('images/publications'), 0777, true);
            }
            // Generate a unique image name using time() and the name from the form
            $newImageName = time() . '-' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->name) . '.' . $request->image->extension();
            // Move the image to the 'public/images/publications' directory
            $request->image->move(public_path('images/publications'), $newImageName);
            $imagePath = 'images/publications/' . $newImageName;
        }

        try {
            // Store the publication in the database with only the relative file paths
            $publication = new Publication();
            $publication->name = $request->name;
            $publication->title = $request->title;
            $publication->publisher = $request->publisher;
            $publication->year = $request->year;
            $publication->google_scholar_link = $request->google_scholar_link;
            $publication->attachment = $attachmentPath;
            $publication->image = $imagePath;
            $publication->save();

            // Redirect with success message
            return redirect()->back()->with('success', 'Publication added successfully!');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error saving publication: ' . $e->getMessage());
            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error saving publication. Please try again.');
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $publication = Publication::findOrFail($id);

        return view('admin.publication.show', compact('publication'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $publication = Publication::findOrFail($id);

        return view('admin.publication.edit', compact('publication'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'google_scholar_link' => 'nullable|url|max:500',
            'attachment' => 'nullable|mimes:pdf|max:51200',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:51200'
        ]);
    
        $publication = Publication::findOrFail($id);
    
        if ($request->hasFile('attachment')) {
            // Create directory if it doesn't exist
            if (!file_exists(public_path('documents/publications'))) {
                mkdir(public_path('documents/publications'), 0777, true);
            }
            $filename = $request->file('attachment')->getClientOriginalName();
            $request->file('attachment')->move(public_path('documents/publications'), $filename);
            $publication->attachment = 'documents/publications/' . $filename;
        }
    
        if ($request->hasFile('image')) {
            // Create directory if it doesn't exist
            if (!file_exists(public_path('images/publications'))) {
                mkdir(public_path('images/publications'), 0777, true);
            }
            $newImageName = time() . '-' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->name) . '.' . $request->image->extension();
            $request->image->move(public_path('images/publications'), $newImageName);
            $publication->image = 'images/publications/' . $newImageName;
        }
    
        $publication->name = $request->name;
        $publication->title = $request->title;
        $publication->publisher = $request->publisher;
        $publication->year = $request->year;
        $publication->google_scholar_link = $request->google_scholar_link;
        $publication->updated_at = now();
        
        try {
            $publication->save();
            return redirect('admin/publication')->with('flash_message', 'Publication updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating publication: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating publication. Please try again.');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Publication::destroy($id);

        return redirect('admin/publication')->with('flash_message', 'Publication deleted!');
    }
}
