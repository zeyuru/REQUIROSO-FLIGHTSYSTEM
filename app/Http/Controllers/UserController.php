<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserStatus;
class UserController extends Controller
{
    public function index()
    {
        return User::with('role', 'status')->get();
    }

    public function show(User $user)
    {
        return $user->load('role', 'status');
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    // In app/Http/Controllers/UserController.php

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'user_status' => 'sometimes|string|in:Active,Inactive,Suspended' // Match seeded values
        ]);
    
        // Ensure status is valid or default to 'Active'
        $status = UserStatus::where('name', $request->user_status ?? 'Active')->first();
        
        // If no status found, set to 'Active'
        if (!$status) {
            $status = UserStatus::where('name', 'Active')->first();
        }
    
        // Create the user with validated data and the status_id
        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => $validatedData['role_id'],
            'status_id' => $status->id // Use status_id here, not status
        ]);
    
        return response()->json($user, 201);
    }
    

public function approveUser($id)
{
    $user = User::findOrFail($id);
    $user->status_id = 1; // Approved
    $user->save();

    return response()->json(['message' => 'User approved successfully']);
}

public function deleteUser($id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}




}

