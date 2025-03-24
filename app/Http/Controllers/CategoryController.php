<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::withCount('tiles')->get();
            return $this->responseSuccess(CategoryResource::collection($categories));
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
            return $this->responseError('Something went wrong, please try again later.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $category = Category::create($request->only(['name', 'description']));
            return $this->responseSuccess(new CategoryResource($category), 'Category Created Successfully', 201);
        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage(), ['request_data' => $request->all()]);
            return $this->responseError('Something went wrong', $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->responseSuccess(new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $category->update($request->only(['name', 'description']));
            return $this->responseSuccess(new CategoryResource($category), 'Category Updated Successfully');
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage(), ['request_data' => $request->all()]);
            return $this->responseError('Something went wrong', $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->responseSuccess(null, 'Category Deleted Successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return $this->responseError('Something went wrong', $e->getMessage(), 500);
        }
    }
}