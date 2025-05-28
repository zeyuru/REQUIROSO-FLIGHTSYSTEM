<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller; // ✅ Add this line if not present
use App\Models\UserStatus;


class AuthController extends Controller
{
 
public function register(Request $request)
{
    $validatedData = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|confirmed|min:6',
        'role_id' => 'required|exists:roles,id',
        'status' => 'sometimes|string|in:Active,Inactive,Suspended'
    ]);

    $status = null;

    if (!empty($validatedData['status'])) {
        $status = UserStatus::where('status', $validatedData['status'])->first();
    }

    if (!$status) {
        $status = UserStatus::where('status', 'Active')->first();

        if (!$status) {
            return response()->json(['error' => 'Default user status not found'], 500);
        }
    }

    $user = User::create([
        'first_name' => $validatedData['first_name'],
        'last_name' => $validatedData['last_name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
        'role_id' => $validatedData['role_id'],
        'status_id' => $status->id
    ]);

    return response()->json(['user' => $user], 201);
}



    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('flightapptoken')->plainTextToken;

        return response()->json([
            'user' => $user,
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
