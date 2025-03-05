<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $medicalRecords = MedicalRecord::all();
        return response()->json($medicalRecords);
    }

    public function show($id)
    {
        $medicalRecord = MedicalRecord::find($id);
        if (!$medicalRecord) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        return response()->json($medicalRecord);
    }

    public function create(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'prescription' => 'required|string',
            'date' => 'required|date',
        ]);
    
        $existingRecord = MedicalRecord::where('patient_id', $request->patient_id)
            ->where('prescription', $request->prescription)
            ->where('date', $request->date)
            ->first();
            
        if ($existingRecord) {
            return response()->json([
                'message' => 'Medical record already exists.',
                'medical_record' => $existingRecord
            ], 409); 
        }
    
        $medicalRecord = MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'prescription' => $request->prescription,
            'date' => $request->date,
        ]);
    
        return response()->json($medicalRecord, 201);
    }
    

    public function update(Request $request, $id)
    {
        $medicalRecord = MedicalRecord::find($id);
        if (!$medicalRecord) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $request->validate([
            'prescription' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $medicalRecord->update([
            'prescription' => $request->prescription,
            'date' => $request->date,
        ]);

        return response()->json($medicalRecord);
    }

    public function delete($id)
    {
        $medicalRecord = MedicalRecord::find($id);
        if (!$medicalRecord) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        $medicalRecord->delete();
        return response()->json(['message' => 'Record deleted']);
    }
}
