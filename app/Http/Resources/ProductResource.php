<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        // Custum dữ liệu muốn hiển thị
        return [
            'id' => $this->id,
            'ma_sp' => $this->ma_san_pham,
            'ten_sp' => $this->ten_san_pham,
            'category' => $this->categories->ten_danh_muc
        ];
    }
}
