<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Discount extends Controller
{
    public static function getDiscount($cart): array
    {
        $quantity = 0;
        foreach ($cart->products as $product) {
            $quantity += $product->pivot->quantity;
        }
        $today = strftime('%u', strtotime(today()));
        $discount = 0;
        if ($quantity >= 2) $discount = '10%';
        if ($quantity >= 3) $discount = '15%';
        if ($today == 6 || $today == 7) $discount = '20%';
        return ['quantity' => $quantity, 'discount' => $discount];
    }
}
