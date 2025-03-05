<?php

namespace App\Http\Controllers;

use App\Models\HealthCheck;
use Illuminate\Http\Request;

class HealthCheckController extends Controller
{
    // List all health checks
    public function index()
    {
        return response()->json(HealthCheck::all());
    }

    // Show a single health check
    public function show($id)
    {
        $healthCheck = HealthCheck::find($id);

        if (!$healthCheck) {
            return response()->json(['message' => 'Health Check not found'], 404);
        }

        return response()->json($healthCheck);
    }

    // Create a new health check
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'tests_offer' => 'required|integer',
            'price' => 'required|numeric',
            'services' => 'required|array',
        ]);

        $healthCheck = HealthCheck::create([
            'name' => $request->name,
            'age' => $request->age,
            'tests_offer' => $request->tests_offer,
            'price' => $request->price,
            'services' => $request->services,
        ]);

        return response()->json($healthCheck, 201);
    }

    // Update a health check
    public function update(Request $request, $id)
    {
        $healthCheck = HealthCheck::find($id);

        if (!$healthCheck) {
            return response()->json(['message' => 'Health Check not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'age' => 'required|integer',
            'tests_offer' => 'required|integer',
            'price' => 'required|numeric',
            'services' => 'required|array',
        ]);

        $healthCheck->update([
            'name' => $request->name,
            'age' => $request->age,
            'tests_offer' => $request->tests_offer,
            'price' => $request->price,
            'services' => $request->services,
        ]);

        return response()->json($healthCheck);
    }

    // Delete a health check
    public function destroy($id)
    {
        $healthCheck = HealthCheck::find($id);

        if (!$healthCheck) {
            return response()->json(['message' => 'Health Check not found'], 404);
        }

        $healthCheck->delete();

        return response()->json(['message' => 'Health Check deleted successfully']);
    }
}
