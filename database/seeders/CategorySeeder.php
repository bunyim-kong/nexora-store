<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            [
                'name' => 'IEM',
                'des' => 'Good quality cable earphones',
                'image_path' => 'category/iem.jpg',
            ],

            [
                'name' => 'Keyboard',
                'des' => 'Premium products, brand and comfortable to use.',
                'image_path' => 'category/keyboard.png',
            ],

            [
                'name' => 'Mouse',
                'des' => 'Great mouse with their shape.',
                'image_path' => 'category/mouse.jpg',
            ],

            [
                'name' => 'Controller',
                'des' => 'Responsive controllers for gaming on any platform.',
                'image_path' => 'category/controller.jpg',
            ],

            [
                'name' => 'Microphone',
                'des' => 'Clear, crisp audio for streaming and recording.',
                'image_path' => 'category/mic.jpg',
            ],

            [
                'name' => 'Monitor Arm',
                'des' => 'Flexible mounting for a cleaner, ergonomic setup.',
                'image_path' => 'category/monitor-arm.jpg',
            ],

            [
                'name' => 'Monitor Stand',
                'des' => 'Sturdy stands to raise your screen to eye level.',
                'image_path' => 'category/laptop-stand.webp',
            ],

            [
                'name' => 'Mousepad',
                'des' => 'Smooth surface built for precision and comfort.',
                'image_path' => 'category/mousepad.jpg',
            ],

            [
                'name' => 'Wireless Buds',
                'des' => 'Tangle-free sound, ready whenever you are.',
                'image_path' => 'category/wireless-buds.png',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
