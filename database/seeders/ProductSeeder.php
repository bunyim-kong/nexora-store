<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $products = [
            [
                "name" => "Attack Shark X3",
                'image' => 'product/mouse.jpg',
                'des' => 'An ultra-lightweight wireless gaming mouse',
                "price" => 30,
                "quantity" => 3,
                "discount_price" => 10,
            ],

            [
                'name' => "Attack Shark K86",
                'image' => 'product/keyboard-2.webp',
                'des' => 'A 75% hot-swappable mechanical gaming keyboard',
                'price' => 50,
                'quantity' => 4,
                'discount_price' => 15,
            ],

            [
                'name' => 'KZ ZST X',
                'image' => 'product/iem.webp',
                'des' => 'Popular budget hybrid dual-driver in ear-monitors',
                'price' => 20,
                'quantity' => 7,
                'discount_price' => 10,
            ],

            [
                "name" => "VGN Dragonfly R1",
                'image' => 'product/mouse-2.jpeg  ',
                'des' => 'An ultra-lightweight ergonomic wireless gaming mouse.',
                "price" => 30,
                "quantity" => 3,
                "discount_price" => 10,
            ],

            [
                'name' => "AULA F75",
                'image' => 'product/keyboard.jpg',
                'des' => 'A 75% gasket-mount wireless mechanical keyboard',
                'price' => 50,
                'quantity' => 4,
                'discount_price' => 15,
            ],

            [
                'name' => 'KZ ZSN Pro',
                'image' => 'product/iem-2.jpeg',
                'des' => 'Hybrid in-ear monitor earphones featuring zinc',
                'price' => 20,
                'quantity' => 7,
                'discount_price' => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
