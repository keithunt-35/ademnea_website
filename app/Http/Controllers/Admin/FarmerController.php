<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Models\Farmer;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    public function index(Request $request)
    {        
        $perPage = 25;
        $farmer = Farmer::with('user')->latest()->paginate($perPage);
        return view('admin.farmer.index', compact('farmer'));
    }

    public function create()
    {
        return view('admin.farmer.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telephone' => 'required|string|max:15',
            'address' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'district' => 'required|string|max:255',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create a new user
            $user = User::create([
                'name' => $validatedData['fname'] . ' ' . $validatedData['lname'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'farmer',
            ]);

            // Create a new farmer associated with the user
            $farmer = new Farmer([
                'fname' => $validatedData['fname'],
                'lname' => $validatedData['lname'],
                'gender' => $validatedData['gender'],
                'address' => $validatedData['address'],
                'telephone' => $validatedData['telephone'],
                'district' => $validatedData['district'],
            ]);

            // Associate the farmer with the user
            $user->farmer()->save($farmer);

            // Commit the transaction
            DB::commit();

            return redirect('admin/farmer')
                ->with('success', 'Farmer added successfully!');

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            \Log::error('Error creating farmer: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Error creating farmer. Please try again.');
        }
    }

    public function show($id)
    {
        $farmer = Farmer::with('user')->findOrFail($id);
        return view('admin.farmer.show', compact('farmer'));
    }

    public function edit($id)
    {
        $farmer = Farmer::with('user')->findOrFail($id);
        return view('admin.farmer.edit', compact('farmer'));
    }

    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        
        $farmer = Farmer::with('user')->findOrFail($id);
        $farmer->update($requestData);
    
        // Update the associated user
        $farmer->user->update([
            'name' => $requestData['fname'] . ' ' . $requestData['lname'],
            'email' => $requestData['email'],
            // Only update the password if a new one is set
            'password' => $requestData['password'] ? Hash::make($requestData['password']) : $farmer->user->password,
        ]);
    
        return redirect('admin/farmer')->with('flash_message', 'Farmer updated!');
    }

    public function destroy($id)
    {
        Farmer::destroy($id);
        return redirect('admin/farmer')->with('flash_message', 'Farmer deleted!');
    }
}