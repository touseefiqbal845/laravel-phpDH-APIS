<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SearchableTrait;

class DoctorController extends Controller
{
    public function create(Request $request)
    {
       
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'career' => 'required|string',
            'experience' => 'required|string',
            'speciality' => 'required|string',
            'stories' => 'nullable|array',
            'stories.*' => 'string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_favourite' => 'nullable|boolean',
            'reviews' => 'nullable|numeric',
            'hour_rate' => 'nullable|numeric',
            'time_slot' => 'nullable|array',
            'details' => 'nullable|array',
            'is_featured' => 'nullable|boolean'
        ]);
    
        $existingDoctor = Doctor::where('name', $validatedData['name'])
                                ->where('career', $validatedData['career'])
                                ->where('speciality', $validatedData['speciality'])
                                ->first();
                                
    
        if ($existingDoctor) {
            return response()->json([
                'status' => 'error',
                'message' => 'Doctor already exists!',
                'doctor' => $existingDoctor
            ], 409); 
        }
    
        $doctor = Doctor::create([
            'name' => $validatedData['name'],
            'career' => $validatedData['career'],
            'experience' => $validatedData['experience'],
            'speciality' => $validatedData['speciality'],
            'stories' => json_encode($validatedData['stories'] ?? []),
            'rating' => $validatedData['rating'],
            'is_favourite' => $validatedData['is_favourite'],
            'reviews' => $validatedData['reviews'],
            'hour_rate' => $validatedData['hour_rate'],
            'time_slot' => json_encode($validatedData['time_slot'] ?? []),
            'details' => json_encode($validatedData['details'] ?? []),
            'is_featured' => $validatedData['is_featured'],
        ]);
    
        return response()->json([
            'status' => 'success',
            'doctor' => $doctor
        ], 201);
    }
    

    // Get doctor by ID
    public function show($id)
    {
        $doctor = Doctor::find($id);
    
        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }
    
        return view('doctors.show', compact('doctor'));
    }
    

    // Update doctor details
    public function update(Request $request, $id)
    {

        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $doctor->update($request->all());

        return response()->json($doctor);
    }

    // Delete doctor by ID
    public function destroy($id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully']);
    }

   
    public function index(Request $request)
{
    $searchableColumns = ['name', 'career', 'speciality']; 
    $doctors = Doctor::applySearchFilters($request, $searchableColumns);
    
    // return response()->json($doctors);
    return view('doctors.index', compact('doctors'));

}

public function getPopularDoctors(Request $request)
    {
        $query = Doctor::withCount([
            'appointments as completed_appointments' => function ($query) {
                $query->whereIn('status', ['confirmed', 'completed']);
            }
        ])
        ->whereHas('appointments', function ($query) {
            $query->whereIn('status', ['confirmed', 'completed']);
        });

        $searchableColumns = ['name', 'career', 'speciality'];
        $query = $query->applySearchFilters($request, $searchableColumns);

        if ($request->has('popular')) {
            $query = $query->orderByDesc('completed_appointments')
                           ->orderByDesc('rating')
                           ->orderByDesc('reviews');
        }

        return response()->json($query);
    }
    public function getFeaturedDoctors(Request $request)
    {
        $query = Doctor::where('is_featured', true);
        $searchableColumns = ['name', 'career', 'speciality'];
        $query = $query->applySearchFilters($request, $searchableColumns);
        $query = $query->orderByDesc('rating')
                       ->orderByDesc('reviews');

        return response()->json($query->get());
    }



}
