<?php

namespace Modules\Purchase\Http\Controllers\Api\V1;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;
use Modules\Purchase\Entities\Order;
use Modules\Purchase\Entities\OrderItem;
use Modules\Purchase\Entities\Transaction;
use function view;

class OrderController extends Controller
{
    /**
     * @param $request
     * @param $amounts
     * @param $token
     * Create Order , Order Items and Transaction
     */
    public static function create($request, $amounts, $token)
    {
        DB::beginTransaction();

        $order = Order::create([
            'user_id' => $request->user_id,
            'total_amount' => $amounts['totalAmount'],
            'delivery_amount' => $amounts['deliveryAmount'],
            'paying_amount' => $amounts['payingAmount'],
        ]);
        foreach ($request->order_items as $orderItem) {
            $product = Product::findOrFail($orderItem['product_id']);
            $order->items()->create([
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $orderItem['quantity'],
                'subtotal' => ($product->price * $orderItem['quantity'])
            ]);
        }
        $order->transaction()->create([
            'user_id' => $request->user_id,
            'amount' => $amounts['payingAmount'],
            'token' => $token,
            'request_from' => $request->request_from
        ]);

        DB::commit();
    }


    /**
     * @param $token
     * @param $transId
     */
    public static function update($token, $transId)
    {
        DB::beginTransaction();

        $transaction = Transaction::where('token', $token)->firstOrFail();
        $transaction->update([
            'status' => 1,
            'trans_id' => $transId,
        ]);
        $order = Order::findOrFail($transaction->order_id);
        $order->update([
            'status' => 1,
            'payment_status' => 1,
        ]);

        foreach (OrderItem::where('order_id', $order->id)->get() as $item) {
            $product = Product::find($item->product_id);
            $product->update([
                'quantity' => ($product->quantity - $item->quantity)
            ]);
        }

        DB::commit();
    }
}
