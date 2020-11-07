<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(2);
        return response()->json($categories, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->parent_id = null;
        $path = $request->file('image')->store('categories_images');
        $category->image = $path;
        
        if ($category->save()) {
            return response()->json($category, 200);
        } else {
            return response()->json([
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:3'
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->parent_id = null;

        $oldPath = $category->image;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('categories_images');
            $category->image = $path;
            Storage::delete($oldPath);
        }
        
        if ($category->save()) {
            return response()->json([
                'category' => $category, 
                'message' => 'Cập nhật danh mục thành công!',
                'status_code' => 200
            ], 200);
        } else {
            Storage::delete($oldPath); 
            return response()->json([
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!',
                'status_code' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            Storage::delete($category->image);
            
            return response()->json([
                'message' => 'Đã xóa danh mục!',
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!',
                'status_code' => 500
            ], 500);
        }
    }
}