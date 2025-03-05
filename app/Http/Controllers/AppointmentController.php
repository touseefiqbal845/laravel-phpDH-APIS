<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
 
        return response()->json(Appointment::with(['patient', 'doctor'])->get());
    }

    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404); 
        }
        return response()->json($appointment);
    }

    public function create(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'time' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|array',
            'status' => 'required|string',
        ]);

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'time' => $request->time,
            'date' => $request->date,
            'location' => $request->location,
            'status' => $request->status,
        ]);

        return response()->json($appointment, 201);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $request->validate([
            'time' => 'sometimes|string',
            'date' => 'sometimes|date',
            'location' => 'sometimes|array',
            'status' => 'sometimes|string',
        ]);

        $appointment->update($request->all());

        return response()->json($appointment);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}
