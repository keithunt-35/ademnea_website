<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Team;
use App\Models\Task;
use Illuminate\Http\Request;


class TeamController extends Controller
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
            $team = Team::where('name', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $team = Team::latest()->paginate($perPage);
        }

        return view('admin.team.index', compact('team'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {

        return view('admin.team.create');
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
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('image')) {
                // Get the file from the request
                $image = $request->file('image');
                
                // Generate a unique filename
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $validatedData['name']) . '.' . $image->getClientOriginalExtension();
                
                // Move the file to the public/images directory
                $image->move(public_path('images'), $imageName);
                
                // Create the team member
                $team = new Team();
                $team->name = $validatedData['name'];
                $team->title = $validatedData['title'];
                $team->description = $validatedData['description'];
                $team->image_path = 'images/' . $imageName; // Store relative path
                
                $team->save();
                
                return redirect('admin/team')
                    ->with('success', 'Team member added successfully!');
            }
            
            return back()
                ->withInput()
                ->with('error', 'Failed to upload image. Please try again.');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error adding team member: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Error adding team member. Please try again.');
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
       
        $team = Team::findOrFail($id);

        return view('admin.team.show', compact('team'));
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
        $team = Team::findOrFail($id);

        return view('admin.team.edit', compact('team'));
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
        
        $requestData = $request->all();
        
        $team = Team::findOrFail($id);
        $team->update($requestData);

        return redirect('admin/team')->with('flash_message', 'Team updated!');
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
        Team::destroy($id);

        return redirect('admin/team')->with('flash_message', 'Team deleted!');
    }
}
