<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SupplierController extends Controller
{
    private const SUCCESS_MESSAGE = 'success';
    private const MESSAGE = 'message';
    private const DATA = 'data';
    private const PAGINATION = 'pagination';
    // funcion para retornar la vista del modulo proveedor
    public function listSupplier(): JsonResponse
    {
        // autorizacion para que pueda acceder al metodo
        Gate::authorize('viewAny', Supplier::class);
        try {
            $name = request('name');
            $suppliers = Supplier::when($name, function ($query, $name) {
                return $query->where('name', 'like', "%$name%");
            })->paginate(20);
            return response()->json([
                self::DATA => SupplierResource::collection($suppliers),
                self::PAGINATION => [
                    'total' => $suppliers->total(),
                    'current_page' => $suppliers->currentPage(),
                    'per_page' => $suppliers->perPage(),
                    'last_page' => $suppliers->lastPage(),
                    'from' => $suppliers->firstItem(),
                    'to' => $suppliers->lastItem(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al cargar los datos',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        Gate::authorize('viewAny', Supplier::class);
        return Inertia::render('Supplier/indexSupplier');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        Gate::authorize('create', Supplier::class);
        $validated = $request->validated();
        // se omite el campo state ya que al crear un nuevo doctor siempre se creara activo
        $validated = $request->safe()->except(['state']);
        $supplier = Supplier::create($validated);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Proveedor creado',
            self::DATA => new SupplierResource($supplier),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        Gate::authorize('view', $supplier);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Proveedor encontrado',
            self::DATA => new SupplierResource($supplier),
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        Gate::authorize('update', $supplier);
        $validated = $request->validated();
        $supplier->update($validated);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Proveedor actualizado',
            self::DATA => new SupplierResource($supplier),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        Gate::authorize('delete', $supplier);
        $supplier->delete();
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => 'Proveedor eliminado',
        ], 200);
    }
}
