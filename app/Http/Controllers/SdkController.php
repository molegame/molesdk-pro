<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Game;
use App\Models\Game\Channel;
use App\Utils\OpenSSL;
use GuzzleHttp\Client;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SdkController extends Controller
{
    /**
     * Handle a verify request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verify(Request $request)
    {
        $player = $request->user();

        return response()->json([
            'openid' => $request->user()->openid
        ], 200);
    }

    /**
     * Handle a pay callback request to the application.
     *
     * @param Request $request
     * @param $channel_id
     * @param $game_id
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request, $channel_id, $game_id)
    {
        $channel = Channel::where([
            ['channel_id', $channel_id],
            ['game_id', $game_id],
        ])->first();

        $result = \Sdk::validatePay($request, $channel);
        // Finish after validate callback
        $this->finishPay($result['order_id'], $result['transaction_id'], $result['amount']);

        return 'SUCCESS';
    }
    
    /**
     * Set the order paid.
     * 
     * @param $order_id
     * @param $transaction_id
     * @param $amount
     */
    protected function finishPay($order_id, $transaction_id, $amount)
    {
        $order = Order::findOrFail($order_id);
        // 未支付
        if ($order->state != Order::STATE_PAYING) {
            throw new \LogicException("Order is not on right state.");
        } 
        // 金额匹配
        if ($order->amount != $amount) {
            throw new \LogicException("Order amount is not match.");
        }
        // 交易号
        $order->transaction_id = $transaction_id;
        // 已支付
        $order->state = Order::STATE_PAID;
        $order->save();

        // 通知游戏服
        $this->notifyGameServer($order);
    }

    /**
     * Notify game server.
     *
     * @param  Order $order
     */
    protected function notifyGameServer($order)
    {
        $app = Game::findOrFail($order->game_id);

        $form_params = [
            'app_id' => $order->game_id,
            'order_id' => $order->id,
            'cp_order_id' => $order->cp_order_id,
            'amount' => $order->amount,
            'callback_info' => $order->callback_info ?? ''
        ];
        $form_params['signature'] = $this->sign($form_params, $app->pri_key);

        $client = new Client();
        $res = $client->request('POST', $order->callback_url ?? $app->pay_callback, [
            'timeout' => 10,
            'form_params' => $form_params
        ]);
        if ($res->getStatusCode() == 200) {
            // 已完成
            $order->state = Order::STATE_COMPLETE;
            $order->save();
        }
    }

    /**
     * @param $params
     */
    protected function sign($params, $key)
    {
        $original = collect($params)->sortKeys()->implode('&');
        return base64_encode(OpenSSL::sign($original, $key));
    }
}
