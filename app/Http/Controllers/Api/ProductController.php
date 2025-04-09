<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Sử dụng Eloquent
        $query = Product::with('categories');

        // Tìm kiếm mã sản phẩm
        if ($request->filled('ma_san_pham')) {
            $query->where('ma_san_pham', 'like', '%' . $request->ma_san_pham . '%');
        }

        $products = $query->paginate(10);

        // return response()->json($products, 200);

        // Sử dụng Resource
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'ma_san_pham' => 'required|string|max:20|unique:products,ma_san_pham',
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'gia' => 'required|numeric|max:9999999',
            'gia_khuyen_mai' => 'nullable|numeric|lt:gia',
            'so_luong' => 'required|integer|min:1',
            'ngay_nhap' => 'required|date',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|boolean'
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Thêm mới
        $product = Product::create($validatedData);

        return response()->json($product, 201);
        // return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Lấy dữ liệu thông tin chi tiết
        $product = Product::with('categories')->findOrFail($id);

        return response()->json([
            'message' => 'Lấy sản phẩm thành công',
            'status' => 200,
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Lấy ra thông tin chi tiết
        $product = Product::findOrFail($id);

        // Validate
        $validatedData = $request->validate([
            'ma_san_pham' => 'required|string|max:20|unique:products,ma_san_pham,' . $id,
            'ten_san_pham' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'gia' => 'required|numeric|max:9999999',
            'gia_khuyen_mai' => 'nullable|numeric|lt:gia',
            'so_luong' => 'required|integer|min:1',
            'ngay_nhap' => 'required|date',
            'mo_ta' => 'nullable|string',
            'trang_thai' => 'required|boolean'
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('images/products', 'public');
            $validatedData['image'] = $imagePath;

            // Xóa ảnh cũ
            if ($product->image) {
                // use Illuminate\Support\Facades\Storage;
                Storage::disk('public')->delete($product->image);
            }
        }

        $product->update($validatedData);

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Lấy ra thông tin chi tiết
        $product = Product::findOrFail($id);

        // Xóa ảnh cũ
        if ($product->image) {
            // use Illuminate\Support\Facades\Storage;
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Xóa sản phẩm thành công']);
    }

    public function restore()
    {
        //
    }

    public function delete()
    {
        //
    }
}
