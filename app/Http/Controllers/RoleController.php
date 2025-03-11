<?php

namespace App\Http\Controllers;

use App\Actions\Pipelines\FilterRole;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private const SUCCESS_MESSAGE = 'success';
    private const MESSAGE = 'message';
    private const DATA = 'data';
    private const PAGINATION = 'pagination';

    public function listRole(Request $request)
    {
        Gate::authorize('viewAny', Role::class);
        try {
            $roles = app(FilterRole::class)->execute([], $request, 20);
            return response()->json([
                self::DATA => RoleResource::collection($roles),
                self::PAGINATION => [
                    'total' => $roles->total(),
                    'current_page' => $roles->currentPage(),
                    'per_page' => $roles->perPage(),
                    'last_page' => $roles->lastPage(),
                    'from' => $roles->firstItem(),
                    'to' => $roles->lastItem(),
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
        Gate::authorize('viewAny', Role::class);
        return Inertia::render('Role/indexRole');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        Gate::authorize('create', Role::class);
        // validated and omitted request state
        $validated = $request->safe()->except(['state']);
        $role = Role::create($validated);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => "Rol $role->name creado correctamente",
            self::DATA => new RoleResource($role),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        Gate::authorize('view', $role);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => "Rol $role->name cargado correctamente",
            self::DATA => new RoleResource($role),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        Gate::authorize('update', $role);
        $validated = $request->validated();
        $role->update($validated);
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => "Rol $role->name actualizado correctamente",
            self::DATA => new RoleResource($role),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('delete', $role);
        $role->delete();
        return response()->json([
            self::SUCCESS_MESSAGE => true,
            self::MESSAGE => "Rol $role->name eliminado correctamente",
        ]);
    }
}
