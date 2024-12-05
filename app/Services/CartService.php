<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Coupon;

class CartService
{
    public function getCart($userId)
    {

        $cart = Cart::where('user_id', $userId)
            ->where('status', 0)
            ->with('items.product')
            ->firstOrCreate(
                ['user_id' => $userId, 'status' => 0],
                ['status' => 0]
            );;
        $this->updateCart($userId);
        $cart = Cart::where('user_id', $userId)
            ->where('status', 0)
            ->with('items.product')
            ->first();
        return $cart;
    }
    public function updateCart($userId)
    {
        $cart = Cart::where('user_id', $userId)
            ->where('status', 0)
            ->with('items.product')
            ->first();


        $cart->total_price = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        $cart->items_count = $cart->items->sum('quantity');

        if ($cart->discount > 0) {
            $cart->total_price = $cart->total_price - $cart->discount;
        }

        $cart->save();
        return $cart;
    }

    public function addItem($userId, $data)
    {

        $cart = $this->getCart($userId);
        $product = Product::findOrFail($data['product_id']);

        $quantity = $data['quantity'] ?? 1;

        if ($product->stock < $quantity) {
            throw new \Exception('Yeterli ürün stoğu bulunmuyor.');
        }

        $cartItem = $cart->items()->where('product_id', $data['product_id'])->first();

        if ($cartItem) {
            if ($product->stock < $cartItem->quantity) {
                throw new \Exception('Toplam miktar stoğu aşamaz.');
            }

            $cartItem->quantity += $quantity;
            $cartItem->price = $product->price * $cartItem->quantity;
            $cartItem->save();
        } else {

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price * $quantity,
            ]);
        }

        $this->updateCart($userId);
        $cart = $this->getCart($userId);

        return $cart->load('items.product');
    }



    public function updateItem($userId, $productId, $quantity)
    {
        $cart = $this->getCart($userId);
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if (!$cartItem) {
            throw new \Exception('Sepette böyle bir ürün bulunamadı.');
        }

        $product = Product::findOrFail($productId);

        if ($quantity <= 0) {
            $cartItem->delete();
        } elseif ($quantity === -1) {
            if ($cartItem->quantity <= 1) {
                $cartItem->delete();
            } else {
                $cartItem->quantity -= 1;
                $cartItem->price = $product->price * $cartItem->quantity;
                $cartItem->save();
            }
        } else {
            if ($quantity > $product->stock) {
                throw new \Exception('Yeterli ürün stoğu bulunmuyor.');
            }

            $cartItem->quantity = $quantity;
            $cartItem->price = $product->price * $quantity;
            $cartItem->save();
        }
        $this->updateCart($userId);
        $cart = $this->getCart($userId);

        return $cart->load('items.product');
    }



    public function removeItem($userId, $productId)
    {
        $cart = $this->getCart($userId);
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if (!$cartItem) {
            throw new \Exception('Sepette böyle bir ürün bulunamadı.');
        }
        $cartItem->delete();

        return $cart->load('items.product');
    }
}
