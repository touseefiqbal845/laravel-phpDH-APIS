<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index()
    {
        return response()->json(Patient::all(), 200);
    }

    /**
     * Store a newly created patient.
     */
    public function create(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'location' => 'nullable|string',
            'contact_info.email' => 'required|email',
            'contact_info.phone' => 'required|string',
            'status' => 'required|string',
            'doctors' => 'array|nullable',  
            'medical_records' => 'array|nullable', 
        ]);
    
        $patient = Patient::where('first_name', $request->first_name)
       ->where('last_name', $request->last_name)
       ->where('age', $request->age) 
       ->where('gender', $request->gender)
       ->where('status', $request->status)
       ->where('location', $request->location)
       ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(contact_info, '$.email')) = ?", [$request->contact_info['email']])
       ->first();

    if ($patient) {
        return response()->json([
            'status' => 'error',
            'message' => 'Patient already exists!',
            'doctor' => $patient
        ], 409); 
    }
if (!$patient) {
    $patient = Patient::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'age' => $request->age,
        'gender' => $request->gender,
        'location' => $request->location,
        'contact_info' => json_encode($request->contact_info), 
        'status' => $request->status,
    ]);
}

if ($patient) {
    if ($request->has('doctors')) {
        $patient->doctors()->syncWithoutDetaching($request->doctors); 
    }
}
    
        return response()->json($patient->load('doctors', 'medicalRecords'), 201);
    }
    
    

    /**
     * Display the specified patient.
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        return response()->json($patient, 200);
    }

    /**
     * Update the specified patient.
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'age' => 'sometimes|required|integer|min:0|max:150',
            'gender' => 'sometimes|required|string|in:Male,Female,Other',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'location' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|unique:patients,email,' . $patient->id,
            'phone' => 'sometimes|required|string|regex:/^[0-9]{10,15}$/',
            'status' => 'nullable|string|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $patient->update($request->all());

        return response()->json($patient, 200);
    }

    /**
     * Remove the specified patient.
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully'], 200);
    }
}
