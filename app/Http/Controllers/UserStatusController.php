<?php

namespace App\Http\Controllers;

use App\Models\UserStatus;
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    public function index()
    {
        return UserStatus::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|unique:user_statuses',
        ]);

        return UserStatus::create($request->all());
    }

    public function show(UserStatus $userStatus)
    {
        return $userStatus;
    }

    public function update(Request $request, UserStatus $userStatus)
    {
        $userStatus->update($request->all());
        return $userStatus;
    }

    public function destroy(UserStatus $userStatus)
    {
        $userStatus->delete();
        return response()->noContent();
    }
}
