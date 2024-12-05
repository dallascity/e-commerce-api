<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use App\Services\CartService;
use Exception;

class OrderService
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrderFromCart($userId)
    {

        $cart = Cart::where('user_id', $userId)->with('items.product')->where('status', 0)->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new Exception('Sepetiniz boş.');
        }


        $totalAmount = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        if ($cart->discount > 0) {
            $totalAmount -= $cart->discount;
        }


        $order = Order::create([
            'user_id' => $userId,
            'cart_id' => $cart->id,
            'total_amount' => $totalAmount,
            'status' => 'Onaylandi',
        ]);

        foreach ($cart->items as $item) {
            $product = $item->product;

            if ($product->stock < $item->quantity) {
                throw new Exception('Ürün stoğu yetersiz: ' . $product->name);
            }


            $product->decrement('stock', $item->quantity);
        }

        $cart->update(['status' => 1]);

        return $order->load('cart.items.product');
    }

    public function getUserOrders(int $userId)
    {
        return Order::where('user_id', $userId)
            ->with('cart.items.product')
            ->latest()
            ->get();
    }

    public function getOrder(int $userId, int $orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', $userId)
            ->with('cart.items.product')
            ->first();

        if (!$order) {
            throw new Exception('Sipariş bulunamadı.');
        }

        return $order;
    }
}
