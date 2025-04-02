<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'ma_san_pham',
        'ten_san_pham',
        'category_id',
        'image',
        'gia',
        'gia_khuyen_mai',
        'so_luong',
        'ngay_nhap',
        'mo_ta',
        'trang_thai'
    ];

    protected $dates = ['deleted_at']; // Đảm bảo Laravel hiểu đây là kiểu ngày tháng

    // Tạo mối quan hệ với bảng Categories
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
