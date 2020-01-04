<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories =  Category::select('id', 'name', 'is_published', 'created_at')->get();
        return response()->json([
            'categories' => $categories
        ], 200);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:2|max:50',
            'is_published' => 'nullable',
        ]);

        try {
            $category = new Category();
            $category->name = request()->name;
            $category->is_published = request()->is_published;
            $category->save();

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Something Wrong. Please Try Again!!!',
                'type' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'Category Added Successfully',
            'type' => 'success'
        ]);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'category' => $category
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required|min:2|max:50',
            'is_published' => 'nullable',
        ]);

        try {
            $category->name = request()->name;
            $category->is_published = request()->is_published;
            $category->save();

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Something Wrong. Please Try Again!!!',
                'type' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'Category Updated Successfully',
            'type' => 'success'
        ]);
    }


    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => 'Something Wrong. Please Try Again!!!',
                'type' => 'error'
            ]);
        }

        return response()->json([
            'message' => 'Category Deleted Successfully',
            'type' => 'success'
        ]);
    }
}
