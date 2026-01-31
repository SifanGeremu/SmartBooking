<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments.
     */
    public function index()
    {
        $user = auth()->user();

        // Admin sees all appointments
        if ($user->hasRole('admin')) {
            return response()->json([
                'appointments' => Appointment::all()
            ]);
        }

        // Regular user sees only their own appointments
        return response()->json([
            'appointments' => Appointment::where('user_id', $user->id)->get()
        ]);
    }

    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_time' => 'required|date|after:now', // must be in future
            'notes'     => 'nullable|string',
        ], [
            'date_time.after' => 'The appointment date and time must be in the future.',
        ]);

        $appointment = Appointment::create([
            'user_id'   => auth()->id(),
            'date_time' => $validated['date_time'],
            'status'    => 'pending', // default status
            'notes'     => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'message'     => 'Appointment created successfully',
            'appointment' => $appointment
        ], 201);
    }

    /**
     * Display a specific appointment.
     */
    public function show(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = auth()->user();

        if (!$user->hasRole('admin') && $appointment->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return response()->json(['appointment' => $appointment]);
    }

    /**
     * Update a specific appointment.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = auth()->user();

        // Ownership check for regular users
        if ($user->hasRole('user') && $appointment->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $validated = $request->validate([
            'date_time' => 'sometimes|date|after:now',
            'notes'     => 'nullable|string',
            'status'    => 'sometimes|string',
        ], [
            'date_time.after' => 'The appointment date and time must be in the future.',
        ]);

        // Only admin can change status
        if (isset($validated['status']) && !$user->hasRole('admin')) {
            return response()->json(['error' => 'Only admins can change status'], 403);
        }

        $appointment->update($validated);

        return response()->json([
            'message'     => 'Appointment updated successfully',
            'appointment' => $appointment
        ]);
    }

    /**
     * Delete a specific appointment.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = auth()->user();

        if (!$user->hasRole('admin') && $appointment->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
