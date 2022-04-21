<?php

namespace Modules\Purchase\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Purchase\Entities\Transaction;
use Modules\Purchase\Http\Requests\PaymentSendRequest;
use Modules\Purchase\Http\Requests\PaymentVerfyRequest;

class PaymentController extends Controller
{
    public function send(PaymentSendRequest $request)
    {
        $totalAmount = 0;
        $deliveryAmount = 0;
        foreach ($request->order_items as $orderItem) {
            $product = Product::findOrFail($orderItem['product_id']);
            if ($product->quantity < $orderItem['quantity']) {
                return $this->errorResponse('The product quantity is incorrect', 422);
            }
            $totalAmount += $product->price * $orderItem['quantity'];
            $deliveryAmount += $product->delivery_amount;
        }

        $payingAmount = $totalAmount + $deliveryAmount;
        $amounts = [
            'totalAmount' => $totalAmount,
            'deliveryAmount' => $deliveryAmount,
            'payingAmount' => $payingAmount
        ];

        $api = config('app.modules.purchase.config.gateway.pay.api');
        $amount = $payingAmount . '0';
        $mobile = "شماره موبایل";
        $factorNumber = "شماره فاکتور";
        $description = "توضیحات";
        $redirect = config('app.modules.purchase.config.gateway.pay.redirect');
        $result = $this->sendRequest($api, $amount, $redirect, $mobile, $factorNumber, $description);
        $result = json_decode($result);
        if ($result->status) {
            OrderController::create($request, $amounts, $result->token);
            $go = "https://pay.ir/pg/$result->token";
            return successResponse([
                'url' => $go,
                'status' => $result->status,
                'token' => $result->token,

            ], 200);
        } else {
            return errorResponse($result->errorMessage, 422);
        }
    }

    /**
     * @param Request $request
     * Verify
     */

    public function verify(PaymentVerfyRequest $request)
    {
        $api = config('app.modules.purchase.config.gateway.pay.api');
        $token = $request->token;
        $result = json_decode($this->verifyRequest($api, $token));
        if (isset($result->status)) {
            if ($result->status == 1) {
                if (Transaction::where('trans_id', $result->transId)->exists()) {
                    return errorResponse('این تراکنش قبلا در این سیستم ثبت شده است', 422);
                }
                OrderController::update($token, $result->transId);
                return successResponse('تراکنش با موفقیت اتجام شد', 200);
            } else {
                return errorResponse('تراکنش با خطا مواجه شد', 422);
            }
        } else {
            if ($request->status == 0) {
                return errorResponse('تراکنش با خطا مواجه شد', 422);
            }
        }
    }

    /**
     * @param $api
     * @param $token
     * @return bool|string
     * Verify request
     */

    public function verifyRequest($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }


    /**
     * @param $api
     * @param $amount
     * @param $redirect
     * @param null $mobile
     * @param null $factorNumber
     * @param null $description
     * @return bool|string
     * Send request to Pay.ir gateway
     */
    public function sendRequest($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api' => $api,
            'amount' => $amount,
            'redirect' => $redirect,
            'mobile' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
        ]);
    }


    /**
     * @param $url
     * @param $params
     * @return bool|string
     * client url methode
     */
    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }
}
