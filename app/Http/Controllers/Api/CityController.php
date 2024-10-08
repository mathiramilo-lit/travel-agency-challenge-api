<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCityRequest;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // Filter by airline (show cities that have flights originating from or destined for a specific airline)

        //! Error: when validation fails, laravel redirects to '/' (Validating url query params)
        $validated = $request->validate([
            'page_size' => 'nullable|integer|min:1|max:50',
            'sort_by' => 'nullable|in:id,name',
            'order' => 'nullable|in:asc,desc',
        ]);

        $pageSize = $validated['page_size'] ?? 10;
        $sortBy = $validated['sort_by'] ?? 'updated_at';
        $order = $validated['order'] ?? 'desc';

        // $pageSize = $request->query('page_size', 10); --------------------------------------------
        // $sortBy = $request->query('sort_by', 'id'); ------------------------------------------------
        // $order = $request->query('order', 'asc'); --------------------------------------------

        $cities = City::orderBy($sortBy, $order)->paginate($pageSize);
        return response()->json($cities, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request): JsonResponse
    {
        $city = City::create($request->validated());
        return response()->json($city, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city): JsonResponse
    {
        return response()->json($city, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCityRequest $request, City $city): JsonResponse
    {
        $city->update($request->validated());
        return response()->json($city, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city): JsonResponse
    {
        $city->delete();
        return response()->json(['message' => "$city->name deleted"], 200);
    }
}
