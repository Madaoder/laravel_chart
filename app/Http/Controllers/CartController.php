<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Ecpay\Sdk\Exceptions\RtnException;

class CartController extends Controller
{
    public function showCart(Request $request)
    {
        $cart = $request->session()->get('cart');
        $total = $request->session()->get('total');
        return view('cart.show', ['items' => $cart, 'total' => $total]);
    }

    public function addItem(Request $request, $id)
    {
        $item = Item::find($id);
        $newCart = [
            'id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'qty' => 1,
        ];
        $cart = $request->session()->has('cart') ? $request->session()->get('cart') : [];
        if (array_key_exists($id, $cart)) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = $newCart;
        }
        $total = $request->session()->has('total') ? $request->session()->get('total') : 0;
        $total += $item->price;
        $request->session()->put('cart', $cart);
        $request->session()->put('total', $total);
        return Redirect()->back();
    }

    public function changeQty(Request $request, $id)
    {
        $cart = $request->session()->get('cart');
        $total = $request->session()->get('total');
        $qty = $request->qty;
        $oldQty = $cart[$id]['qty'];
        $diff = $qty - $oldQty;
        $cart[$id]['qty'] = $qty;
        $total += $diff * $cart[$id]['price'];
        $request->session()->put('cart', $cart);
        $request->session()->put('total', $total);
        return Redirect()->action([CartController::class, 'showCart']);
    }

    public function deleteItem(Request $request, $id)
    {
        $cart = $request->session()->get('cart');
        $total = $request->session()->get('total');
        $total -= $cart[$id]['qty'] * $cart[$id]['price'];
        unset($cart[$id]);
        $request->session()->put('cart', $cart);
        $request->session()->put('total', $total);
        return Redirect()->action([CartController::class, 'showCart']);
    }

    public function buyItem(Request $request)
    {
        $order = $request->session()->pull('cart');
        $total = $request->session()->pull('total');
        $tradeNo = bin2hex(random_bytes(9));
        Order::create([
            'user_id' => Auth::id(),
            'order' => serialize($order),
            'total' => $total,
            'trade_no' => $tradeNo,
        ]);
        try {
            $factory = new Factory([
                'hashKey' => '5294y06JbISpM5x9',
                'hashIv' => 'v77hoKGq4kWxNNIS'
            ]);
            $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

            $input = [
                'MerchantID' => '2000132',
                'MerchantTradeNo' => $tradeNo,
                'MerchantTradeDate' => date('Y/m/d H:i:s'),
                'PaymentType' => 'aio',
                'TotalAmount' => $total,
                'TradeDesc' => UrlService::ecpayUrlEncode('交易描述範例'),
                'ItemName' => '範例信用卡交易',
                'ReturnURL' => 'http://7ea8-1-165-201-77.ngrok.io/cart/callback',
                'ClientBackURL' => 'http://7ea8-1-165-201-77.ngrok.io',
                'ChoosePayment' => 'Credit',
                'EncryptType' => 1,
            ];

            $input['CheckMacValue'] = CheckMacValue::generate($input, '5294y06JbISpM5x9', 'v77hoKGq4kWxNNIS');

            $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

            echo $autoSubmitFormService->generate($input, $action);
        } catch (RtnException $e) {
            echo '(', $e->getCode() . ')' . $e->getMessage() . PHP_EOL;
        }
    }

    public function callback(Request $request)
    {
        if ($request->RtnCode === 1) {
            Order::where('trade_no', $request->MerchantTradeNo)
                ->update(['paid', 1]);
        }
    }
}

class CheckMacValue
{
    static function generate($arParameters = array(), $HashKey = "", $HashIV = "")
    {
        $sMacValue = "";
        if (isset($arParameters)) {
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, array('App\Http\Controllers\CheckMacValue', 'merchantSort'));

            $sMacValue = "HashKey=" . $HashKey;
            foreach ($arParameters as $key => $value) {
                $sMacValue .= "&" . $key . "=" . $value;
            }
            $sMacValue .= "&HashIV=" . $HashIV;

            $sMacValue = urlencode($sMacValue);

            $sMacValue = strtolower($sMacValue);

            $sMacValue = str_replace('%2d', '-', $sMacValue);
            $sMacValue = str_replace('%5f', '_', $sMacValue);
            $sMacValue = str_replace('%2e', '.', $sMacValue);
            $sMacValue = str_replace('%21', '!', $sMacValue);
            $sMacValue = str_replace('%2a', '*', $sMacValue);
            $sMacValue = str_replace('%28', '(', $sMacValue);
            $sMacValue = str_replace('%29', ')', $sMacValue);

            $sMacValue = hash('sha256', $sMacValue);
            $sMacValue = strtoupper($sMacValue);
        }
        return $sMacValue;
    }

    private static function merchantSort($a, $b)
    {
        return strcasecmp($a, $b);
    }
}
