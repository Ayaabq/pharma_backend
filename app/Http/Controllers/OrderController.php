<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Notifications\AdminNotification;


class OrderController extends Controller
{
    public function addproduct(User $user, Request $request,)
    {


        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'order_price' => 'required|integer',
            'products' => 'required|array',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

      if(  $order = Order::create([
            'user_id' => $validatedData['user_id'],
            'order_price' => $request->order_price,
            'status' => 'In_Preparation',
            'payment_status' => 'not_paid'
        ])){

        auth()->user()->notify(new AdminNotification($order));

        }



        foreach ($validatedData['products'] as $productDats) {
            $order->products()->attach($productDats['id'], ['quantity' => $productDats['quantity']]);
        }



        return new OrderResource($order);
    }
}
