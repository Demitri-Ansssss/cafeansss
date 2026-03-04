<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    // get all products
    public function  index(){
        $products = Product::all();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Get All Products successfully',
        //     'data' => $products
        // ]);
        return view('order', ['products' => $products]);
    }
    // post product
    public function store(Request $request){
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required',
            'description' => 'required|string',
            'is_available' => 'required|string'
        ]);
        $imagePath = $request->input('image');

        // 1. CEK: Apakah input 'image' adalah FILE?
        if ($request->hasFile('image')) {
            // Validasi tambahan khusus file
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Simpan ke disk 'public' (storage/app/public/images)
            $imagePath = $request->file('image')->store('images', 'public');
        } 
        // 2. CEK: Apakah input 'image' adalah URL (string)?
        elseif (filter_var($request->image, FILTER_VALIDATE_URL)) {
            $imagePath = $request->image;
        }

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'description' => $request->description,
            'is_available' => $request->is_available === 'Tersedia' ? 'Tersedia' : 'Tidak Tersedia'
        ]);

        return new ProductResource(
            $product
        );
    }

    // get product by id
    public function show($id){
        $product = Product::find($id);
       if (!$product) {
        return response()->json([
            'message' => 'Product not found',
        ]);
       }else {
        return response()->json([
            'message' => ' Get Product successfully',
            'data' => $product
        ]);
       }
    }

    // update product
 public function update(Request $request, $id)
{
    $product = Product::find($id);

    $product->update($request->all());

    return response()->json([
        'message' => 'Product updated successfully',
        'data' => $product
    ]);
}
    // delete product
    public function destroy($id){
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'data' => $product
        ]);
    }
};
