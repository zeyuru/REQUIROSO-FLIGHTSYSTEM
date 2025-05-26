<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return Booking::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'passenger_id' => 'required|exists:passengers,id',
            'flight_id' => 'required|exists:flights,id',
            'booking_reference' => 'required|unique:bookings',
            'booking_date' => 'required|date',
        ]);

        $booking = Booking::create($validated);

        return response()->json([
            'message' => 'Booking created successfully.',
            'booking' => $booking,
        ], 201);
    }

    public function show(Booking $booking)
    {
        return $booking;
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'passenger_id' => 'sometimes|exists:passengers,id',
            'flight_id' => 'sometimes|exists:flights,id',
            'booking_reference' => 'sometimes|unique:bookings,booking_reference,' . $booking->id,
            'booking_date' => 'sometimes|date',
        ]);

        $booking->update($validated);

        return response()->json([
            'message' => 'Booking updated successfully.',
            'booking' => $booking,
        ]);
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->json([
            'message' => 'Booking cancelled successfully.'
        ]);
    }
}
