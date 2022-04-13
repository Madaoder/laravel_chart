<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class HomeController extends Controller
{
    public function home()
    {
        $items = Item::all();
        return view('home', ['items' => $items]);
    }

    public function computer()
    {
        $computers = Item::where('tag', 'computer')->get();
        return view('home', ['items' => $computers]);
    }

    public function mouse()
    {
        $mouses = Item::where('tag', 'mouse')->get();
        return view('home', ['items' => $mouses]);
    }

    public function keyboard()
    {
        $keyboards = Item::where('tag', 'keyboard')->get();
        return view('home', ['items' => $keyboards]);
    }
}
