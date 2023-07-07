<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckApiKey;
use App\Models\User;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(CheckApiKey::class);
    }

    public function userActiveOrders(User $user)
    {
        $orders = $user->orders()->where('status', true)->get();
        $products = [];

        foreach ($orders as $order) {
            $product = $order->product;
            $order->status = false; // set status to false
            $order->save(); // save the updated order
            $products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $order->quantity,
                'item' => $product->item,
                'command' => $product->command,
            ];
        }

        return response()->json($products);
    }
}
