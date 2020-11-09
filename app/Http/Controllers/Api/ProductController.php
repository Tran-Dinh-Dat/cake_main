<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(2);

        return response()->json($products, 200);
    }

    public function categories()
    {
        $categories = Category::all();
        
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'category_id' => 'required',
            'price' => 'required|numeric|min:1000',
            'discount' => 'required|numeric|min:1000',
            'quantity' => 'required|numeric',
            'description' => 'required|string|max:200',
            'content' => 'required|string',
            'sku' => 'required|max:4|min:4',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->content = $request->content;
        $product->sku = $request->sku;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->views = $request->views;
        $product->slug = Str::slug($request->name);
        $path = $request->file('image')->store('products_images');
        $product->image = $path;
        if ($product->save()) {
            return response()->json($product, 200);
        } else {
            return response()->json([
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau!',
                'status_code' => 500
            ], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'min:3',
            'price' => 'numeric|min:1000',
            'discount' => 'numeric|min:1000',
            'quantity' => 'numeric',
            'description' => 'string|max:200',
            'content' => 'string',
            'sku' => 'max:4|min:4',
        ]);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->content = $request->content;
        $product->sku = $request->sku;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->slug = Str::slug($request->name);

        $oldPath = $product->image;
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('products_images');
            $product->image = $path;
            Storage::delete($oldPath);
        }
        
        if ($product->save()) {
            return response()->json([
                'product' => $product, 
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

    public function destroy(Product $product)
    {
        if ($product->delete()) {
            Storage::delete($product->image);
            
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
