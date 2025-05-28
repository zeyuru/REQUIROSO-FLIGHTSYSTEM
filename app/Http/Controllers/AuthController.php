<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
{
    // Get all valid statuses from DB for validation
    $validStatuses = UserStatus::pluck('name')->toArray();

    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|string|email|unique:users,email',
        'password'   => 'required|string|confirmed|min:6',
        'role_id'    => 'required|exists:roles,id',
        'status'     => ['sometimes', 'string', Rule::in($validStatuses)],
    ]);

    // Find status object or default to "Active"
    $status = null;
    if (!empty($validatedData['status'])) {
        $status = UserStatus::where('name', $validatedData['status'])->first();
    }

    if (!$status) {
        $status = UserStatus::where('name', 'Active')->first();
        if (!$status) {
            return response()->json(['error' => 'Default user status "Active" not found.'], 500);
        }
    }

    // Create user with the proper status_id
    $user = User::create([
        'first_name' => $validatedData['first_name'],
        'last_name'  => $validatedData['last_name'],
        'email'      => $validatedData['email'],
        'password'   => bcrypt($validatedData['password']),
        'role_id'    => $validatedData['role_id'],
        'status_id'  => $status->id,
    ]);

    return response()->json(['user' => $user], 201);
}

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('flightapptoken')->plainTextToken;

        return response()->json([
            'user'  => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
