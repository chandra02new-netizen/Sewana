<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'size'       => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'All Size']),
            'color'      => $this->faker->randomElement(['Merah Marun', 'Hitam', 'Putih', 'Biru Dongker', 'Cokelat', 'Krem', 'Emas', 'Hijau Botol', 'Salem']),
            'price'      => $this->faker->randomElement([80000, 100000, 120000, 140000, 160000]),
            'stock'      => 1,
            'status'     => 'tersedia',
        ];
    }
}
