<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\OrderStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        $totalPrice = $product->price * $request->quantity;

        if (Auth::user()->balance < $totalPrice) {
            return redirect()->back()->withErrors(['balance' => 'Not enough money.']);
        }

        $orderData = [
            'user_id' => auth()->user()->id,
            'product_id' => $request->product_id,
            'status' => 1,
            'price' => $product->price * $request->quantity,
            'quantity' => $product->type == 'item' ? ($product->amount * $request->quantity) : $request->quantity,
        ];

        Order::updateOrCreate([
            'user_id' => $orderData['user_id'],
            'product_id' => $orderData['product_id'],
            'status' => $orderData['status'],
            'price' => $orderData['price'],
        ], $orderData);

        Auth::user()->withdraw($totalPrice);

        return redirect()->back();
    }
}
