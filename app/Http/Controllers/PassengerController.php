<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function index()
    {
        return Passenger::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:passengers',
            // Add other validations
        ]);

        return Passenger::create($request->all());
    }

  public function show($id)
{
    $passenger = Passenger::find($id);

    if (!$passenger) {
        return response()->json(['message' => 'Passenger not found'], 404);
    }

    return response()->json($passenger);
}




    public function update(Request $request, $id)
{
    $passenger = Passenger::find($id);

    if (!$passenger) {
        return response()->json(['message' => 'Passenger not found'], 404);
    }

    // Proceed to update...
}


    public function destroy($id)
{
    $passenger = Passenger::find($id);

    if (!$passenger) {
        return response()->json([
            'message' => 'Passenger not found.'
        ], 404);
    }

    $passenger->delete();

    return response()->json([
        'message' => 'Passenger deleted successfully.'
    ], 200);
}

}
