<?php

namespace App\Services;

use App\Services\MacValueService;
use Ecpay\Sdk\Exceptions\RtnException;
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;

class EcpayService
{
    static public function moveToBuyPage($tradeNo, $order)
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
                'TotalAmount' => $order->total,
                'TradeDesc' => UrlService::ecpayUrlEncode('交易描述範例'),
                'ItemName' => '範例信用卡交易',
                'ReturnURL' => config('app.url') . 'cart/callback',
                'ClientBackURL' => config('app.url'),
                'ChoosePayment' => 'Credit',
                'EncryptType' => 1,
            ];

            $input['CheckMacValue'] = MacValueService::generate($input, '5294y06JbISpM5x9', 'v77hoKGq4kWxNNIS');

            $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

            echo $autoSubmitFormService->generate($input, $action);
        } catch (RtnException $e) {
            echo '(', $e->getCode() . ')' . $e->getMessage() . PHP_EOL;
        }
    }
}
