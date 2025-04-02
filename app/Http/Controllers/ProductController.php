<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Hàm lấy ra danh sách sản phẩm
    public function index(Request $request)
    {
        // Sử dụng Eloquent
        $query = Product::with('categories');

        // Tìm kiếm mã sản phẩm
        if ($request->filled('ma_san_pham')) {
            $query->where('ma_san_pham', 'like', '%' . $request->ma_san_pham . '%');
        }

        // Tìm kiếm theo: Tên sản phẩm, Danh mục, Khoảng giá, Ngày nhập, Trạng thái


        $products = $query->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // Hàm hiển thị chi tiết sản phẩm
    public function show($id)
    {
        // Lấy dữ liệu thông tin chi tiết
        $product = Product::with('categories')->findOrFail($id);
        // dd($product);
        // Hiển thị dữ liệu ra màn hình chi tiết sản phẩm 
        return view('admin.products.show', compact('product'));
    }

    // Hàm hiển thị giao diện trang thêm
    public function create()
    {
        // Lấy ra danh sách danh mục
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Hàm thêm dữ liệu
    public function store(Request $request)
    {
        // $product = new Product();

        // // Lấy dữ liệu gửi từ Form
        // $product->ma_san_pham       = $request->ma_san_pham;
        // $product->ten_san_pham      = $request->ten_san_pham;
        // $product->category_id       = $request->category_id;
        // $product->gia               = $request->gia;
        // $product->gia_khuyen_mai    = $request->gia_khuyen_mai;
        // $product->so_luong          = $request->so_luong;
        // $product->ngay_nhap         = $request->ngay_nhap;
        // $product->mo_ta             = $request->mo_ta;
        // $product->trang_thai        = $request->trang_thai;

        // // Xử lý hình ảnh
        // if ($request->hasFile('image')) {
        //     $imagePath = $request->file('image')->store('images/products', 'public');
        //     $product->image = $imagePath;
        // }

        // // Thêm dữ liệu
        // $product->save();

        // return redirect()->route('admin.products.index');


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
            $imagePath = $request->file('image')
                ->store('images/products', 'public');
            $validatedData['image'] = $imagePath;
        }

        // Thêm mới
        Product::create($validatedData);

        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        $product = Product::with('categories')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
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

        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        // Lấy ra thông tin chi tiết
        $product = Product::findOrFail($id);

        // Xóa ảnh cũ
        if ($product->image) {
            // use Illuminate\Support\Facades\Storage;
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }
}
