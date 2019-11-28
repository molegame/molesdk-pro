<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Utils\IDGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('player');
    }

    /**
     * Handle a create request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validateCreate($request);

        if ($order = $this->attemptCreate($request)) {
            return $this->sendCreateResponse($request, $order);
        }
        return $this->sendFailedCreateResponse($request);
    }

    /**
     * Validate the order create request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreate(Request $request)
    {
        $request->validate([
            'app_id' => 'required|string|max:255',
            'product_id' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'cp_order_id' => 'nullable|string|max:255',
            'callback_url' => 'nullable|string|max:255',
            'callback_info' => 'nullable|string|max:255',
        ]);
    }

    /**
     * Attempt to create an order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Model\Order  $order
     */
    protected function attemptCreate(Request $request)
    {
        $player = $request->user();
        $data = $request->all();

        for ($i = 0; $i < 3; ++$i) {
            try {
                $order = Order::create([
                    'id' => IDGenerator::ouid(),
                    'game_id' => $player->game_id,
                    'channel_id' => $player->channel_id,
                    'player_id' => $player->id,
                    'currency' => 'CNY',
                    'amount' => $data['amount'],
                    'product_id' => $data['product_id'],
                    'product_name' => $data['product_name'],
                    'cp_order_id' => $data['cp_order_id'] ?? null,
                    'callback_url' => $data['callback_url'] ?? null,
                    'callback_info' => $data['callback_info'] ?? null,
                ]);
                break;
            } catch (\Exception $exception) {
            }
        }
        return $order;
    }

    /**
     * Send the response after the order was created.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Order  $order
     * 
     * @return \Illuminate\Http\Response
     */
    protected function sendCreateResponse(Request $request, $order)
    {
       return response()->json([
           'order_id' => $order->id,
           'currency' => $order->currency,
           'amount' => $order->amount
       ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedCreateResponse(Request $request)
    {
        return response()->json([
            'message' => trans('failed'),
            'status_code' => 500
        ], 500);
    }
}
