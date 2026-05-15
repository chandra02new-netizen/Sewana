<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $clothingTypes = [
            'Kebaya Modern',
            'Kebaya Wisuda',
            'Kebaya Brokat',
            'Jas Formal Pria',
            'Dress Bridesmaid',
            'Gaun Pesta',
            'Baju Adat Sunda',
            'Baju Adat Jawa',
            'Batik Couple',
            'Beskap',
            'Dress Lamaran',
            'Tunik Kondangan',
        ];

        $colors = [
            'Merah Marun',
            'Hitam',
            'Putih',
            'Biru Dongker',
            'Cokelat',
            'Krem',
            'Salem',
            'Emas',
            'Hijau Botol',
            'Navy',
        ];

        $productName = $this->faker->randomElement($clothingTypes)
            . ' ' . $this->faker->randomElement($colors);

        return [
            'name'        => $productName,
            'sku'         => 'SWN-' . strtoupper($this->faker->unique()->bothify('??##')),
            'description' => 'Rental ' . $productName . ' untuk acara resmi seperti kondangan, wisuda, lamaran, atau pesta malam. Bahan bersih dan rapi, siap pakai.',
            'base_price'  => $this->faker->randomElement([80000, 100000, 120000, 140000, 160000, 180000]),
            'status'      => $this->faker->randomElement(['active', 'active', 'active', 'inactive']),
        ];
    }
}
