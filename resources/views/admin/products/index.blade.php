@extends('layouts.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <h1 class="mb-4">Danh sách sản phẩm</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
        + Thêm sản phẩm
    </a>

    <!-- Form tìm kiếm -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-search"></i> Tìm kiếm sản phẩm</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}">
                <div class="row g-3">
                    <!-- Mã sản phẩm -->
                    <div class="col-md-3">
                        <label class="form-label">Mã sản phẩm</label>
                        <input type="text" name="ma_san_pham" class="form-control" placeholder="Nhập mã sản phẩm"
                            value="{{ request('ma_san_pham') }}">
                    </div>
                    
                    <!-- Nút tìm kiếm & Làm mới -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 me-1">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary w-100 ms-1">
                            <i class="fas fa-sync"></i> Làm mới
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Mã SP</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Ảnh</th>
                <th>Giá</th>
                <th>Giá KM</th>
                <th>Số lượng</th>
                <th>Ngày nhập</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->ma_san_pham }}</td>
                    <td>{{ $product->ten_san_pham }}</td>
                    <td>{{ $product->categories->ten_danh_muc ?? 'Chưa có danh mục' }}</td>
                    <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->ten_san_pham }}"
                                width="60">
                        @else
                            Không có ảnh
                        @endif
                    </td>
                    <td>{{ number_format($product->gia, 0, ',', '.') }} VND</td>
                    <td>
                        @if ($product->gia_khuyen_mai)
                            {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }} VND
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $product->so_luong }}</td>
                    <td>{{ date('d/m/Y', strtotime($product->ngay_nhap)) }}</td>
                    <td>
                        @if ($product->trang_thai)
                            <span class="badge bg-success">Đang bán</span>
                        @else
                            <span class="badge bg-danger">Ngừng bán</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-primary btn-sm">Xem</a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        
                        <form action="{{ route('admin.products.destroy', $product->id) }}" class="d-inline"
                            method="POST" onsubmit="return confirm('Bạn có muốn xóa không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Hiển thị phân trang -->
    <div class="d-flex justify-content-end mt-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection
