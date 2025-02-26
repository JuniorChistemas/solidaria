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
                'data' => CategoryResource::collection($categories), 
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
        }


    public function update(CategoryRequest $request, Category $category)
        {
            $category->update($request->validated());
        }



    public function destroy(Category $category)
        {
            $category->delete();
        }

}
