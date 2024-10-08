<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAirlineRequest;
use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filter by City (show all airlines that have a flight in that city)

        //! Error: when validation fails, laravel redirects to '/'
        $validated = $request->validate([
            'limit' => 'nullable|integer|min:1|max:50',
            'sort_by' => 'nullable|in:id,name,description,created_at,updated_at',
            'order' => 'nullable|in:asc,desc',
        ]);

        $limit = $validated['limit'] ?? 10;
        $sortBy = $validated['sort_by'] ?? 'updated_at';
        $order = $validated['order'] ?? 'desc';

        // $limit = $request->query('limit', 10); -----------------------------------------------------
        // $sortBy = $request->query('sort_by', 'id'); ------------------------------------------------
        // $order = $request->query('order', 'asc'); --------------------------------------------------

        $airlines = Airline::orderBy($sortBy, $order)->paginate($limit);
        return response()->json($airlines, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAirlineRequest $request)
    {
        $airline = airline::create($request->validated());
        return response()->json($airline, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Airline $airline)
    {
        return response()->json($airline, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAirlineRequest $request, Airline $airline)
    {
        $airline->update($request->validated());
        return response()->json($airline, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airline $airline)
    {
        $airline->delete();
        return response()->json(['message' => "$airline->name deleted"], 200);
    }
}
