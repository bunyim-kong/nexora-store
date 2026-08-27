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
                "name" => "Gaming Mouse",
                'image' => 'product/mouse.jpg',
                'des' => 'Aula SC620',
                "price" => 30,
                "quantity" => 3,
                "discount_price" => 10,
            ],

            [
                'name' => "Keyboard Gaming",
                'image' => 'product/keyboard.jpg',
                'des' => 'Attack Shark',
                'price' => 50,
                'quantity' => 4,
                'discount_price' => 15,
            ],

            [
                'name' => 'IEM Earphones',
                'image' => 'product/iem.webp',
                'des' => 'Qkz 6 Pro.',
                'price' => 20,
                'quantity' => 7,
                'discount_price' => 10,
            ],

            [
                "name" => "Gaming Mouse",
                'image' => 'product/mouse-2.jpeg  ',
                'des' => 'Aula Gaming',
                "price" => 30,
                "quantity" => 3,
                "discount_price" => 10,
            ],

            [
                'name' => "Keyboard Gaming",
                'image' => 'product/keyboard-2.webp',
                'des' => 'Aula F75 Fake',
                'price' => 50,
                'quantity' => 4,
                'discount_price' => 15,
            ],

            [
                'name' => 'IEM Earphones',
                'image' => 'product/iem-2.jpeg',
                'des' => 'Moondrop',
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
