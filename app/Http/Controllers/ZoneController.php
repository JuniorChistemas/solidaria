<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZoneRequest;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ZoneController extends Controller
{

    // ! not used constants in controller


    private const SUCCESS_MESSAGE = 'success';
    private const MESSAGE = 'message';
    private const DATA = 'data';
    private const PAGINATION = 'pagination';

    public function show(Zone $zone): JsonResponse
    {
        return response()->json(new ZoneResource($zone));
    }

    public function index()
    {
        Gate::authorize('viewAny', Zone::class);
        return Inertia::render('Zone/indexZone');
    }

    public function listZone(Request $request): JsonResponse
    {
        $zones = Zone::when($request->query('name'), function ($query, $name) {
            return $query->where('name', 'like', "%$name%");
        })->paginate(10);

        return response()->json([
            'data' => ZoneResource::collection($zones),
            'pagination' => [
                'total' => $zones->total(),
                'current_page' => $zones->currentPage(),
                'per_page' => $zones->perPage(),
                'last_page' => $zones->lastPage(),
                'from' => $zones->firstItem(),
                'to' => $zones->lastItem(),
            ]
        ]);
    }



    // ! don't use a single request for store and update methods, create a separate request for each method storeRequest and updateRequest

    public function store(ZoneRequest $request): JsonResponse
    {
        Gate::authorize('create', Zone::class);
        $zone = Zone::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Zona creada',
            'data' => new ZoneResource($zone),
        ], 201);
    }

    public function update(ZoneRequest $request, Zone $zone): JsonResponse
    {
        Gate::authorize('update', $zone);
        $zone->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Zona Actualizada',
            'data' => new ZoneResource($zone),
        ], 200);
    }

    public function destroy(Zone $zone): JsonResponse
    {
        Gate::authorize('delete', $zone);
        $zone->delete();

        return response()->json([
            'success' => true,
            'message' => 'Zona Eliminada',
        ], 200);
    }
}
