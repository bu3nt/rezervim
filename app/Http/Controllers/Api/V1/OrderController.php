<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveOrderRequest;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        return response()->json($orders);
    }

    public function store(SaveOrderRequest $request)
    {
        $order = Order::create([
            'order_id' => $request->orderId
        ]);

        foreach ($request->products as $productData) {
            $product = new Product([
                'product_id' => $productData['id'],
                'name' => $productData['name'],
            ]);
            $order->products()->save($product);
        }

        return response()->json($order, 201);
    }
}
