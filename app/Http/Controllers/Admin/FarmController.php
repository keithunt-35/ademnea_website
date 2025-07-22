<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Models\Farm;
use App\Models\Farmer;
use Illuminate\Http\Request;


class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {        
        $perPage = 25;
       
        // Get all farmers with their user data for the dropdown
        $farmers = Farmer::with('user')->get();

        // Get all farms with their owner data and paginate
        $farm = Farm::with(['farmer.user'])
                   ->latest()
                   ->paginate($perPage);

        return view('admin.farm.index', compact('farm', 'farmers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Load farmers with their associated user data
        $farmers = Farmer::with('user')->get();

        return view('admin.farm.create', compact('farmers'));
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
            'ownerId' => 'required|exists:farmers,id',
            'name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        try {
            // Create the farm
            $farm = new Farm();
            $farm->ownerId = $validatedData['ownerId'];
            $farm->name = $validatedData['name'];
            $farm->district = $validatedData['district'];
            $farm->address = $validatedData['address'];
            
            $farm->save();
            
            return redirect('admin/farm')
                ->with('success', 'Farm added successfully!');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error adding farm: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Error adding farm. Please try again.');
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
        // Load the farm with its owner and owner's user data
        $farm = Farm::with(['farmer.user'])->findOrFail($id);

        return view('admin.farm.show', compact('farm'));
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
        // Load the farm with its owner data
        $farm = Farm::with(['farmer'])->findOrFail($id);
        // Get all farmers for the dropdown
        $farmers = Farmer::with('user')->get();

        return view('admin.farm.edit', compact('farm', 'farmers'));
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
        // Validate the request data
        $validatedData = $request->validate([
            'ownerId' => 'required|exists:farmers,id',
            'name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        try {
            // Find the farm
            $farm = Farm::findOrFail($id);
            
            // Update the farm
            $farm->ownerId = $validatedData['ownerId'];
            $farm->name = $validatedData['name'];
            $farm->district = $validatedData['district'];
            $farm->address = $validatedData['address'];
            
            $farm->save();
            
            return redirect('admin/farm')
                ->with('success', 'Farm updated successfully!');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error updating farm: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Error updating farm. Please try again.');
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
        try {
            // Find the farm
            $farm = Farm::findOrFail($id);
            
            // Delete the farm
            $farm->delete();
            
            return redirect('admin/farm')
                ->with('success', 'Farm deleted successfully!');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting farm: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Error deleting farm. Please try again.');
        }
    }


    
}
