@extends('layouts.admin')

@section('title', 'Thêm mới sản phẩm')

@section('content')
    <h1 class="mb-4">Thêm mới sản phẩm</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf
        
                <div class="row">
                    <!-- Mã sản phẩm -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mã sản phẩm</label>
                        <input type="text" name="ma_san_pham" 
                            class="form-control @error('ma_san_pham') is-invalid @enderror" 
                            value="{{ old('ma_san_pham') }}">
                        @error('ma_san_pham')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        {{-- BTVN: Hiển thị lỗi ở các trường tiếp theo --}}
                    </div>
        
                    <!-- Tên sản phẩm -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="ten_san_pham" class="form-control" value="{{ old('ten_san_pham') }}">
                    </div>
        
                    <!-- Danh mục -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->ten_danh_muc }}
                                </option>
                            @endforeach
                        </select>
                    </div>
        
                    <!-- Ảnh sản phẩm -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ảnh sản phẩm</label>
                        <input type="file" name="image" class="form-control">
                    </div>
        
                    <!-- Giá và Giá khuyến mãi -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" name="gia" class="form-control" value="{{ old('gia') }}">
                    </div>
        
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá khuyến mãi</label>
                        <input type="number" name="gia_khuyen_mai" class="form-control" value="{{ old('gia_khuyen_mai') }}">
                    </div>
        
                    <!-- Số lượng -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="so_luong" class="form-control" value="{{ old('so_luong') }}">
                    </div>
        
                    <!-- Ngày nhập -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày nhập</label>
                        <input type="date" name="ngay_nhap" class="form-control" value="{{ old('ngay_nhap') }}">
                    </div>
        
                    <!-- Mô tả -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="mo_ta" class="form-control" rows="3">{{ old('mo_ta') }}</textarea>
                    </div>
        
                    <!-- Trạng thái -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="trang_thai" class="form-select">
                            <option value="1" {{ old('trang_thai') == '1' ? 'selected' : '' }}>Đang bán</option>
                            <option value="0" {{ old('trang_thai') == '0' ? 'selected' : '' }}>Ngừng bán</option>
                        </select>
                    </div>
        
                    <!-- Nút gửi -->
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm sản phẩm
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
