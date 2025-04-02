<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Model muốn thao tác với bảng nào thì sẽ cần quy định ở biến table
    protected $table = 'categories';

    // $fillable: cho phép điền dữ liệu vào các cột tương ứng
    protected $fillable = [
        'ten_danh_muc',
        'trang_thai'
    ];

    // Tạo mối quan hệ với bảng Product (1 - N)
    public function products() 
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
