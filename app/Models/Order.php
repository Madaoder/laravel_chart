<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Http\Controllers\CheckMacValue;
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Ecpay\Sdk\Exceptions\RtnException;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order',
        'total',
        'trade_no'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getSumAttribute()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += ($item->price * $item->pivot->qty);
        }
        return $sum;
    }

    public function moveToBuyPage($tradeNo)
    {
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
                'TotalAmount' => $this->fillable['total'],
                'TradeDesc' => UrlService::ecpayUrlEncode('交易描述範例'),
                'ItemName' => '範例信用卡交易',
                'ReturnURL' => env('APP_URL') . 'cart/callback',
                'ClientBackURL' => env('APP_URL'),
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
}
