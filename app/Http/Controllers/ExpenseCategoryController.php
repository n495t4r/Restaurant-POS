<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory; // Make sure to import the ExpenseCategory model
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ExpenseCategory::all(); // Retrieve all expense categories
        return view('expenses.category', compact('categories')); // Pass the categories to the view
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        try {
            $category = ExpenseCategory::create($request->all());
            return response()->json(['success' => 'Category created successfully', 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create category']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        try {
            $category = ExpenseCategory::findOrFail($id);
            $category->update($request->all());
            return response()->json(['success' => 'Category updated successfully', 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update category']);
        }
    }

    //Show category
    public function show($id)
    {
        try {
            $category = ExpenseCategory::findOrFail($id);
            return response()->json(['category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch category'], 404);
        }
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $category = ExpenseCategory::findOrFail($id);
            $category->delete();
            return response()->json(['success' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category']);
        }
    }
}