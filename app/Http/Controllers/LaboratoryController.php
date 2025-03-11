<?php

namespace App\Http\Controllers;

use App\Actions\Pipelines\Filter;
use App\Models\Laboratory;
use App\Http\Requests\StoreLaboratoryRequest;
use App\Http\Requests\UpdateLaboratoryRequest;
use App\Http\Resources\LaboratoryResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class LaboratoryController extends Controller
{

    //Variables globales para estados
    private const SUCCESS_MESSAGE = 'success';
    private const MESSAGE = 'message';
    private const DATA = 'data';
    private const PAGINATION = 'pagination';

    // funcion index para cargar los datos y el filtro para la tabla del modulo laboratorio
    public function index()
    {
        Gate::authorize('viewAny', Laboratory::class);
        return Inertia::render('Laboratory/indexLaboratory');
    }
    
    public function listLaboratory(): JsonResponse
    {
        // autorizacion para que pueda acceder al metodo
        Gate::authorize('viewAny', Laboratory::class);
        try {
            $name = request('name');
            $laboratories = Laboratory::when($name, function ($query, $name) {
                return $query->where('name', 'like', "%$name%");
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);
            return response()->json([
                self::DATA => LaboratoryResource::collection($laboratories),
                self::PAGINATION => [
                    'total' => $laboratories->total(),
                    'current_page' => $laboratories->currentPage(),
                    'per_page' => $laboratories->perPage(),
                    'last_page' => $laboratories->lastPage(),
                    'from' => $laboratories->firstItem(),
                    'to' => $laboratories->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al cargar los datos',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreLaboratoryRequest $request): JsonResponse
    {
        Gate::authorize('create', Laboratory::class);
        $validated = $request->validated();
        // Ommit State ,because is active default
        $validated = $request->safe()->except(['state']);
        $laboratory = Laboratory::create($validated);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Laboratorio creado',
            self::DATA => new LaboratoryResource($laboratory),
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Laboratory $laboratory): JsonResponse
    {
        Gate::authorize('view', $laboratory);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Laboratorio encontrado',
            self::DATA => new LaboratoryResource($laboratory),
        ], 200);
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaboratoryRequest $request, Laboratory $laboratory): JsonResponse
    {
        Gate::authorize('update', $laboratory);
        $validated = $request->validated();
        $laboratory->update($validated);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Laboratorio actualizado',
            self::DATA => new LaboratoryResource($laboratory),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratory $laboratory): JsonResponse
    {
        Gate::authorize('delete', $laboratory);
        $laboratory->delete();
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Laboratorio eliminado',
        ], 200);
    }

    public function searchLaboratory(Request $request)
    {
        // Pass the request to the execute method
        $laboratories = (new Filter())->execute([], $request);
        
        return response()->json([
            self::DATA => LaboratoryResource::collection($laboratories),
            self::PAGINATION => [
                'total' => $laboratories->total(),
                'current_page' => $laboratories->currentPage(),
                'per_page' => $laboratories->perPage(),
                'last_page' => $laboratories->lastPage(),
                'from' => $laboratories->firstItem(),
                'to' => $laboratories->lastItem(),
            ],
        ]);
    }
}
