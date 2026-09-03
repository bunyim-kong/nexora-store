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
        $products = [
            [
                'name' => 'Attack Shark K86',
                'image' => 'product/keyboard-2.webp',
                'des' => '75% hot-swappable mechanical gaming keyboard with screen',
                'price' => 50,
                'quantity' => 4,
                'discount_price' => 15,
            ],
            [
                'name' => 'HyperX SoloCast',
                'image' => 'product/micro-2.jpeg',
                'des' => 'Compact USB condenser gaming microphone with tap-to-mute',
                'price' => 60,
                'quantity' => 5,
                'discount_price' => 10,
            ],
            [
                'name' => 'Attack Shark X3',
                'image' => 'product/mouse.jpg',
                'des' => 'Ultra-lightweight wireless gaming mouse',
                'price' => 30,
                'quantity' => 3,
                'discount_price' => 10,
            ],
            [
                'name' => 'Beitong Pangu AI',
                'image' => 'product/controller-3.webp',
                'des' => 'Wireless gaming controller featuring specialized AI functions',
                'price' => 130,
                'quantity' => 2,
                'discount_price' => 15,
            ],
            [
                'name' => 'KZ ZST X',
                'image' => 'product/iem.webp',
                'des' => 'Popular budget hybrid dual-driver in-ear monitors',
                'price' => 20,
                'quantity' => 7,
                'discount_price' => 10,
            ],
            [
                'name' => 'North Bayou NB F160',
                'image' => 'product/monitor-3.jpg',
                'des' => 'Dual-monitor gas-strut desktop mount arm with desk clamp',
                'price' => 35,
                'quantity' => 4,
                'discount_price' => 10,
            ],
            [
                'name' => 'AULA F75',
                'image' => 'product/keyboard.jpg',
                'des' => '75% gasket-mount wireless mechanical keyboard',
                'price' => 50,
                'quantity' => 4,
                'discount_price' => 15,
            ],
            [
                'name' => 'VXE Dragonfly R1',
                'image' => 'product/mouse-2.jpeg',
                'des' => 'Ultra-lightweight ergonomic wireless gaming mouse',
                'price' => 30,
                'quantity' => 3,
                'discount_price' => 10,
            ],
            [
                'name' => 'FIFINE AmpliGame A8',
                'image' => 'product/microphone-3.jpg',
                'des' => 'USB condenser microphone with RGB lighting and gain control',
                'price' => 45,
                'quantity' => 6,
                'discount_price' => 10,
            ],
            [
                'name' => 'GameSir G3s',
                'image' => 'product/controller-2.jpg',
                'des' => 'Wireless and wired gamepad controller for PC and Android',
                'price' => 25,
                'quantity' => 5,
                'discount_price' => 10,
            ],
            [
                'name' => 'KZ ZSN Pro X',
                'image' => 'product/iem-2.jpeg',
                'des' => 'Hybrid in-ear monitor earphones with zinc alloy faceplates',
                'price' => 20,
                'quantity' => 7,
                'discount_price' => 10,
            ],
            [
                'name' => 'Ergotron LX Wall Mount',
                'image' => 'product/monitor-2.jpeg',
                'des' => 'Heavy-duty adjustable single monitor arm wall mount',
                'price' => 250,
                'quantity' => 2,
                'discount_price' => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}