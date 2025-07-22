<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Farm;
use Illuminate\Support\Facades\DB;
use App\Models\Hive;
use Illuminate\Http\Request;


class HiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get the farm_id from the request query
        $farmId = $request->query('farm_id');
    
        // If farm_id is not provided or is invalid, redirect to farms index with an error
        if (!$farmId || !($farm = Farm::with('farmer.user')->find($farmId))) {
            return redirect()->route('farms.index')
                ->with('error', 'Farm not found or invalid farm ID.');
        }
    
        // Store the farm_id in session
        session(['farm_id' => $farmId]);
    
        // Get hives associated with the farm with pagination
        $hives = Hive::where('farm_id', $farmId)
                    ->latest()
                    ->paginate(10);
    
        // Return the view with the hives and farm data
        return view('admin.hives.index', compact('hives', 'farm'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Get the farm_id from the session
        $farmId = session('farm_id');
        
        // If no farm_id in session, redirect back with error
        if (!$farmId) {
            return redirect()->route('farms.index')
                ->with('error', 'Please select a farm first.');
        }
        
        // Get the farm with its owner data
        $farm = Farm::with('farmer.user')->findOrFail($farmId);
        
        return view('admin.hives.create', compact('farm'));
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
            'farm_id' => 'required|exists:farms,id',
            'name' => 'required|string|max:255',
            'hive_type' => 'required|string|max:100',
            'status' => 'required|string|in:active,inactive,maintenance',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Create the hive
            $hive = new Hive();
            $hive->farm_id = $validatedData['farm_id'];
            $hive->name = $validatedData['name'];
            $hive->hive_type = $validatedData['hive_type'];
            $hive->status = $validatedData['status'];
            $hive->latitude = $validatedData['latitude'] ?? null;
            $hive->longitude = $validatedData['longitude'] ?? null;
            $hive->notes = $validatedData['notes'] ?? null;
            
            $hive->save();
            
            return redirect('admin/hive?farm_id=' . $validatedData['farm_id'])
                ->with('success', 'Hive added successfully!');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error adding hive: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Error adding hive. Please try again.');
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
        // Load the hive with its farm and farm's owner data
        $hive = Hive::with(['farm.farmer.user'])->findOrFail($id);
        
        // Get the farm_id for the back link
        $farmId = $hive->farm_id;
        
        return view('admin.hives.show', compact('hive', 'farmId'));
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
        // Load the hive with its farm data
        $hive = Hive::with(['farm.farmer.user'])->findOrFail($id);
        
        // Get the farm for the form
        $farm = $hive->farm;
        
        return view('admin.hives.edit', compact('hive', 'farm'));
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
            'name' => 'required|string|max:255',
            'hive_type' => 'required|string|max:100',
            'status' => 'required|string|in:active,inactive,maintenance',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            // Find the hive
            $hive = Hive::findOrFail($id);
            
            // Update the hive
            $hive->name = $validatedData['name'];
            $hive->hive_type = $validatedData['hive_type'];
            $hive->status = $validatedData['status'];
            $hive->latitude = $validatedData['latitude'] ?? null;
            $hive->longitude = $validatedData['longitude'] ?? null;
            $hive->notes = $validatedData['notes'] ?? null;
            
            $hive->save();
            
            return redirect('admin/hive?farm_id=' . $hive->farm_id)
                ->with('success', 'Hive updated successfully!');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error updating hive: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Error updating hive. Please try again.');
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
            // Find the hive
            $hive = Hive::findOrFail($id);
            $farmId = $hive->farm_id;
            
            // Delete the hive
            $hive->delete();
            
            return redirect('admin/hive?farm_id=' . $farmId)
                ->with('success', 'Hive deleted successfully!');
                
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting hive: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Error deleting hive. Please try again.');
        }
    }
}
