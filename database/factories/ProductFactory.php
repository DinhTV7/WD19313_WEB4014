<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ma_san_pham' => $this->faker->unique->numerify('SP#####'),
            'ten_san_pham' => $this->faker->word,
            'category_id' => Category::factory(),
            'image' => null,
            'gia' => $this->faker->randomFloat(2, 10000, 99999999),
            'gia_khuyen_mai' => $this->faker->optional()->randomFloat(2, 5000, 9999999),
            'so_luong' => $this->faker->numberBetween(1, 100),
            'ngay_nhap' => $this->faker->date,
            'mo_ta' => $this->faker->sentence,
            'trang_thai' => $this->faker->boolean
        ];
    }
}
