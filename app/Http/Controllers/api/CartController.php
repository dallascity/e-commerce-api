<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreCartItemRequest;
use App\Http\Requests\Api\UpdateCartItemRequest;
use App\Services\CartService;

class CartController extends ApiController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }


    public function index()
    {
        $userId = auth('api')->id();
        try {
            $cart = $this->cartService->getCart($userId);

            if (isset($cart['message']) && $cart['message'] === 'Sepet boş.') {
                return $this->sendSuccess([
                    'message' => $cart['message'],
                    'items' => [],
                ]);
            }

            return $this->sendSuccess($cart, 200, 'Sepetiniz başarıyla getirildi.');
        } catch (\Exception $e) {
            return $this->sendError('Sepet getirilemedi.');
        }
    }


    public function store(StoreCartItemRequest $request)
    {
        $userId = auth('api')->id();
        try {

            $cart = $this->cartService->addItem($userId,  $request->validated());

            return $this->sendSuccess($cart, 201, 'Sepete eklendi.');
        } catch (\Exception $e) {
            return $this->sendError(['message' => $e->getMessage()], 400);
        }
    }



    public function update(UpdateCartItemRequest $request, $id)
    {
        $userId = auth('api')->id();

        $data = $request->validated();
        $quantity = $data['quantity'] ?? -1;

        try {
            $cart = $this->cartService->updateItem($userId, $id, $quantity);


            return $this->sendSuccess($cart, 200, 'Sepet güncellendi.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        $userId = auth('api')->id();

        try {
            $cart = $this->cartService->removeItem($userId, $id);
            return $this->sendSuccess($cart, 200, 'Ürün sepetten kaldırıldı');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 404);
        }
    }
}
