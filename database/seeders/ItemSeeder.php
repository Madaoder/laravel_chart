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
        $image1 = Image::make('public/images/image1.jpg')->resize(300, 200)->save('public/images/computer1.jpg');
        $image2 = Image::make('public/images/image2.jpg')->resize(300, 200)->save('public/images/computer2.jpg');
        $image3 = Image::make('public/images/image3.jpg')->resize(300, 200)->save('public/images/computer3.jpg');
        $image4 = Image::make('public/images/image4.jpg')->resize(300, 200)->save('public/images/mouse1.jpg');
        $image5 = Image::make('public/images/image5.jpg')->resize(300, 200)->save('public/images/mouse2.jpg');
        $image6 = Image::make('public/images/image6.jpg')->resize(300, 200)->save('public/images/mouse3.jpg');
        $image7 = Image::make('public/images/image7.jpg')->resize(300, 200)->save('public/images/keyboard1.jpg');
        $image8 = Image::make('public/images/image8.jpg')->resize(300, 200)->save('public/images/keyboard2.jpg');
        $image9 = Image::make('public/images/image9.jpg')->resize(300, 200)->save('public/images/keyboard3.jpg');
        Item::create(['name' => 'computer1', 'price' => '15000', 'image' => 'images/computer1.jpg', 'tag' => 'computer']);
        Item::create(['name' => 'computer2', 'price' => '20000', 'image' => 'images/computer2.jpg', 'tag' => 'computer']);
        Item::create(['name' => 'computer3', 'price' => '40000', 'image' => 'images/computer3.jpg', 'tag' => 'computer']);
        Item::create(['name' => 'mouse1', 'price' => '800', 'image' => 'images/mouse1.jpg', 'tag' => 'mouse']);
        Item::create(['name' => 'mouse2', 'price' => '2000', 'image' => 'images/mouse2.jpg', 'tag' => 'mouse']);
        Item::create(['name' => 'mouse3', 'price' => '480', 'image' => 'images/mouse3.jpg', 'tag' => 'mouse']);
        Item::create(['name' => 'keyboard1', 'price' => '1500', 'image' => 'images/keyboard1.jpg', 'tag' => 'keyboard']);
        Item::create(['name' => 'keyboard2', 'price' => '300', 'image' => 'images/keyboard2.jpg', 'tag' => 'keyboard']);
        Item::create(['name' => 'keyboard3', 'price' => '4000', 'image' => 'images/keyboard3.jpg', 'tag' => 'keyboard']);
    }
}
