<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'        => 'Kebaya Modern Brokat',
                'description' => 'Kebaya brokat modern cocok untuk kondangan, acara adat, dan resepsi. Bahan halus, rapi, dan mudah dipadupadankan.',
                'base_price'  => 140000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Kebaya Wisuda Satin',
                'description' => 'Kebaya satin elegan untuk wisuda dan acara resmi. Potongan modern dengan warna lembut dan nyaman dipakai seharian.',
                'base_price'  => 130000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Jas Formal Pria Hitam',
                'description' => 'Jas pria hitam slimfit untuk acara formal, lamaran, dan pesta. Kualitas kain nyaman dengan potongan rapi.',
                'base_price'  => 150000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Jas Formal Pria Navy',
                'description' => 'Jas pria navy modern untuk event resmi dan prewedding. Tampil maskulin dengan bahan tidak mudah kusut.',
                'base_price'  => 150000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Dress Bridesmaid Peach',
                'description' => 'Dress bridesmaid warna peach pastel untuk pesta pernikahan. Model simpel tetapi tetap anggun dan elegan.',
                'base_price'  => 120000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Gaun Pesta Satin Emas',
                'description' => 'Gaun pesta satin gold cocok untuk malam gala atau acara formal. Sentuhan mewah dengan detail rapi.',
                'base_price'  => 160000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Baju Adat Sunda Pangsi',
                'description' => 'Baju adat Sunda lengkap dengan pangsi untuk pesta adat dan acara budaya. Bahan kuat dan nyaman dipakai.',
                'base_price'  => 140000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Baju Adat Jawa Beskap',
                'description' => 'Beskap Jawa tradisional untuk acara adat dan lamaran. Desain klasik dengan kombinasi warna elegan.',
                'base_price'  => 150000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Batik Couple Sarimbit',
                'description' => 'Setel batik couple sarimbit cocok untuk acara keluarga atau lamaran. Motif batik elegan dan warna serasi.',
                'base_price'  => 120000,
                'status'      => 'active',
            ],
            [
                'name'        => 'Dress Lamaran Pastel',
                'description' => 'Dress lamaran warna pastel untuk acara lamaran atau tunangan. Model feminim dan nyaman dipakai lama.',
                'base_price'  => 125000,
                'status'      => 'active',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create([
                'name'        => $data['name'],
                'description' => $data['description'],
                'base_price'  => $data['base_price'],
                'status'      => $data['status'],
            ]);

            ProductVariant::factory(rand(2, 4))->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
