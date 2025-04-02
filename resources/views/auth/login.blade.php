@extends('layouts.auth')

@section('title', 'Đăng Nhập')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <h2 class="text-center">Đăng Nhập</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
        </form>
        <p class="mt-3 text-center">
            Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
        </p>
    </div>
</div>
@endsection
