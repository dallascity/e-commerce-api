<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store()
    {
        $userId = auth('api')->id();

        try {
            $order = $this->orderService->createOrderFromCart($userId);
            return $this->sendSuccess($order, 201);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 400);
        }
    }


    public function index()
    {
        $userId = auth('api')->id();
        $orders = $this->orderService->getUserOrders($userId);

        return $this->sendSuccess($orders);
    }

    public function show(int $id)
    {
        $userId = auth('api')->id();

        try {
            $order = $this->orderService->getOrder($userId, $id);
            return $this->sendSuccess($order);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 404);
        }
    }
}
