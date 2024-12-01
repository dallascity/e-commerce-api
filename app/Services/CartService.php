<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

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
            );

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

        return $cart->load('items.product');
    }



    public function updateItem($userId, $productId, $quantity)
    {
        $cart = $this->getCart($userId);
        $cartItem = $cart->where('status', 0)->items()->where('product_id', $productId)->first();

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
