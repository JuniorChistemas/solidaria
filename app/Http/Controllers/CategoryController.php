<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Category/indexCategory');
    }

    public function listCategory(Request $request)
    {
        $categories = Category::when($request->query('name'), function ($query, $name) {
            return $query->where('name', 'like', "%$name%");
        })->paginate(10);
    
        return response()->json([
            'data' => $categories->items(),
            'pagination' => [
                'total' => $categories->total(),
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem(),
            ]
        ]);
    }
    

    public function store(CategoryRequest $request)
{
    $category = Category::create($request->validated());

    return response()->json([
        'message' => 'Categoría agregada exitosamente',
        'category' => new CategoryResource($category)
    ], 201);
}


    public function update(CategoryRequest $request, Category $category)
{
    $category->update($request->validated());

    return response()->json([
        'message' => 'Categoría actualizada exitosamente',
        'category' => new CategoryResource($category)
    ], 200);
}



public function destroy(Category $category)
{
    $category->delete();

    return response()->json(['message' => 'Categoría eliminada exitosamente'], 200);
}

}
