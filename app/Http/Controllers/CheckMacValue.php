<?php

namespace App\Http\Controllers;

class CheckMacValue
{
    public static function generate($arParameters = array(), $hashKey = "", $hashIV = "")
    {
        $sMacValue = "";
        if (isset($arParameters)) {
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, array('App\Http\Controllers\CheckMacValue', 'merchantSort'));

            $sMacValue = "hashKey=" . $hashKey;
            foreach ($arParameters as $key => $value) {
                $sMacValue .= "&" . $key . "=" . $value;
            }
            $sMacValue .= "&hashIV=" . $hashIV;

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
