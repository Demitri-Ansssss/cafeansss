<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    // Get Data Categories
    public function index()
    {
        $categories = Category::all();
        return response()->json([

            'message' => 'Categories fetched successfully',
            'data' => $categories,
        ]);
    }

    // Get Data Category by ID
    public function show($id)
    {
        $categories = Category::find($id);
        if (!$categories) {
            return response()->json([
                'message' => 'Category not found',
            ]);
        }else {
            return response()->json([
                'message' => 'Category fetched successfully',
                'data' => $categories,
            ]);
        }
    }

    // Create Data Category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]); 

        $categories = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);
        return new CategoryResource(
            $categories
        );
    }

    // Update Data Category
    public function update(Request $request, $id)
    {
        $categories = Category::find($id);
        $categories->update($request->all());
        return response()->json([

            'message' => 'Category updated successfully',
            'data' => $categories,
        ]);
    }

    // Delete Data Category
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([

            'message' => 'Category deleted successfully',
            'data' => $category,
        ]);
    }
}
