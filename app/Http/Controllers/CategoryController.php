<?php

namespace App\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Category/indexCategory');
    }

    public function addCategory(Request $request)
    {
        try {
            // Obtener el parámetro 'name' desde GET
            $name = $request->query('name'); 
    
            // Validar que el nombre no esté vacío
            if (!$name) {
                return response()->json(['error' => 'El campo name es obligatorio'], 400);
            }
    
            // Validar que no exista una categoría con el mismo nombre
            if (Category::where('name', $name)->exists()) {
                return response()->json(['error' => 'Esta categoría ya existe'], 409);
            }
    
            // Crear y guardar la nueva categoría
            $category = Category::create([
                'name' => $name
            ]);
    
            return response()->json([
                'message' => 'Categoría agregada exitosamente',
                'category' => $category
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function removeCategory(Request $request)
    {
        try {
            // Obtener el ID desde GET
            $id = $request->query('id');

            if (!$id) {
                return response()->json(['error' => 'El ID de la categoría es obligatorio'], 400);
            }

            // Buscar la categoría
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['error' => 'Categoría no encontrada'], 404);
            }

            // Eliminar la categoría
            $category->delete();

            return response()->json([
                'message' => 'Categoría eliminada exitosamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateCategory(Request $request)
    {
        try {
            // Obtener parámetros desde GET
            $id = $request->query('id');
            $newName = $request->query('name');

            // Validar que ambos valores estén presentes
            if (!$id || !$newName) {
                return response()->json(['error' => 'El ID y el nuevo nombre son obligatorios'], 400);
            }

            // Buscar la categoría
            $category = Category::find($id);

            if (!$category) {
                return response()->json(['error' => 'Categoría no encontrada'], 404);
            }

            // Verificar si el nuevo nombre ya existe en otra categoría
            if (Category::where('name', $newName)->where('id', '!=', $id)->exists()) {
                return response()->json(['error' => 'Ya existe una categoría con este nombre'], 409);
            }

            // Actualizar la categoría
            $category->name = $newName;
            $category->save();

            return response()->json([
                'message' => 'Categoría actualizada exitosamente',
                'category' => $category
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function listCategory(Request $request)
    {
        try {
            $name = $request->query('name');
            $categories = Category::when($name, function ($query, $name) {
                return $query->where('name', 'like', "%$name%");
            })->paginate(10); // Configurar el número de elementos por página

            return response()->json([
                'data' => $categories->items(),
                'pagination' => [
                    'total' => $categories->total(),
                    'current_page' => $categories->currentPage(),
                    'per_page' => $categories->perPage(),
                    'last_page' => $categories->lastPage(),
                    'from' => $categories->firstItem(),
                    'to' => $categories->lastItem(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al cargar las categorías', 'message' => $e->getMessage()], 500);
        }
    }


    

}

