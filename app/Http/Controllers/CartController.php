<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart()
    {
        $order = Order::where('user_id', Auth::user()->id)->first();
        $items = $order->items()->orderBy('price')->get();
        return view('cart.show', compact('order', 'items'));
    }

    public function addItem($id)
    {
        $orderCheck = Order::where('user_id', Auth::user()->id)->first();
        //Wether user have order or not
        if (!$orderCheck) {
            Order::create(['user_id' => Auth::user()->id]);
        }
        $itemCheck = $orderCheck->items()->where('item_id', $id)->first();
        //Wether user have add this item to the chart or not
        if (!$itemCheck) {
            $item = Item::find($id);
            $orderCheck->items()->attach($item->id, ['qty' => 1]);
        }
        return Redirect()->back();
    }

    public function changeQty(Request $request, $id)
    {
        $qty = $request->qty;
        $order = Order::where('user_id', Auth::user()->id)->first();
        $item = Item::find($id);
        $order->items()->updateExistingPivot($item->id, ['qty' => $qty]);
        return Redirect()->back();
    }

    public function deleteItem($id)
    {
        $order = Order::where('user_id', Auth::user()->id)->first();
        $item = Item::find($id);
        $order->items()->detach($item->id);
        return Redirect()->back();
    }
}
