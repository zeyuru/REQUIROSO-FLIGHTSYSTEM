<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;

class FlightController extends Controller
{
    public function index()
    {
        return Flight::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_number' => 'required|unique:flights',
            'departure_airport' => 'required',
            'arrival_airport' => 'required',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'airline' => 'required',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required',
            'aircraft_type' => 'required',
        ]);

        return Flight::create($request->all());
    }

    public function show(Flight $flight)
    {
        return $flight;
    }


public function update(Request $request, $id)
{
    // ✅ Step 1: Validate the incoming request
    $validatedData = $request->validate([
        'flight_number' => 'required|string',
        'departure_airport' => 'required|string',
        'arrival_airport' => 'required|string',
        'departure_time' => 'required|date',
        'arrival_time' => 'required|date|after_or_equal:departure_time',
        'airline' => 'required|string',
        'capacity' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:Active,Inactive',
        'aircraft_type' => 'required|string',
    ]);

    // ✅ Step 2: Find the flight
    $flight = Flight::find($id);

    if (!$flight) {
        return response()->json(['message' => 'Flight not found'], 404);
    }

    // ✅ Step 3: Update the flight
    $flight->update($validatedData);

    // ✅ Step 4: Return success response
    return response()->json([
        'message' => 'Flight updated successfully.',
        'flight' => $flight
    ]);
}



   public function destroy($id)
{
    $flight = Flight::find($id);

    if (!$flight) {
        return response()->json(['message' => 'Flight not found'], 404);
    }

    $flight->delete();

    return response()->json(['message' => 'Flight deleted successfully.']);
}


public function changeStatus($id)
    {
        $flight = Flight::find($id);

        if (!$flight) {
            return response()->json(['message' => 'Flight not found'], 404);
        }

        // Toggle the status between 'Active' and 'Inactive'
        $flight->status = $flight->status === 'Active' ? 'Inactive' : 'Active';
        $flight->save();

        return response()->json([
            'message' => 'Flight status updated successfully.',
            'flight' => $flight,
        ]);
    }

}

