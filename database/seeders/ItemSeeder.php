<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;
use Intervention\Image\Facades\Image;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image1 = Image::make('public/images/image1.jpg')->resize(300, 300)->save('public/images/computer1.jpg');
        $image2 = Image::make('public/images/image2.jpg')->resize(300, 300)->save('public/images/computer2.jpg');
        $image3 = Image::make('public/images/image3.jpg')->resize(300, 300)->save('public/images/computer3.jpg');
        Item::create(['name' => 'computer1', 'price' => '15000', 'image' => 'images/computer1.jpg']);
        Item::create(['name' => 'computer2', 'price' => '15000', 'image' => 'images/computer2.jpg']);
        Item::create(['name' => 'computer3', 'price' => '15000', 'image' => 'images/computer3.jpg']);
    }
}
