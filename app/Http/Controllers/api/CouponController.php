<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Carbon;
use App\Services\CartService;

class CouponController extends ApiController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function store(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', 1)
            ->first();
        $cart = $this->cartService->getCart(auth('api')->id());


        if (isset($coupon) && !Carbon::now()->gt($coupon->expires_at) && $coupon->min_cart_amount < $cart->total_price && $cart->discount == 0) {

            $coupon = Coupon::where('code', $request->code)->first();

            if ($coupon->discount_type === 'percentage') {
                $cart->discount = ($cart->total_price * $coupon->discount_amount) / 100;
            } elseif ($coupon->discount_type === 'fixed') {
                $cart->discount = $coupon->discount_amount;
            }
            if ($cart->total_price < 0) {
                $cart->total_price = 0;
            }
            $cart->save();
            $cart = $this->cartService->getCart(auth('api')->id());

            return $this->sendSuccess($cart, 200, 'Kupon kodu başarıyla aktifleştirildi');
        } else {
            return $this->sendError('Kupon geçersiz');
        }
    }
}
