<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

      
        if ($request->has('brand')) {
            $query->where('brand', 'like', "%{$request->brand}%");
        }

        if ($request->has('model')) {
            $query->where('model', 'like', "%{$request->model}%");
        }

        if ($request->has('year')) {
            $query->where('year_model', $request->year);
        }

        return response()->json($query->paginate(10));

    }

    public function show(Car $car)
    {
        return response()->json($car);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'price' => 'nullable|numeric',
            'external_id' => 'required|integer', 

        ]);

        $car = Car::create($validated);

        return response()->json($car, 201);
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => 'sometimes|string',
            'model' => 'sometimes|string',
            'price' => 'nullable|numeric',
        ]);

        $car->update($validated);

        return response()->json($car);
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json(null, 204);
    }
}