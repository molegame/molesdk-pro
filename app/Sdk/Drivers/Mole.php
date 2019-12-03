<?php

namespace App\Sdk\Drivers;

use App\Sdk\SdkDriver;
use App\Models\Game\Channel;
use App\Utils\OpenSSL;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use Exception;

class Mole implements SdkDriver
{
    /**
    * Create a new hasher instance.
    *
    * @param  array  $options
    * @return void
    */
   public function __construct()
   {
   }

    /**
     * To theck if the token is valid.
     *
     * @param Channel $channel
     * @param  string  $token
     * @return string
     */
    public function verify(Channel $channel, $token)
    {
        $params = json_decode($channel->params, true);
        
        $form_params = [
            'app_id' => $channel->game_id
        ];
        $form_params['signature'] = $this->sign($form_params, $params['app_secret']);

        $client = new Client();
        $res = $client->request('POST', $channel->verifyUrl(), [
            'timeout' => 10,
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$token
            ],
            'form_params' => $form_params
        ]);
        if ($res->getStatusCode() != 200) {
            throw new UnauthorizedException;
        }
        $data = json_decode($res->getBody(), true);

        return $data['openid'];
    }

    /**
     * Validate callback of pay.
     * 
     * @param Channel $channel
     * @param Request $request
     */
    public function validatePay(Request $request, Channel $channel)
    {
        $request->validate([
            'order_id' => 'required|string|max:255',
            'cp_order_id' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'signature' => 'required|string|max:255'
        ]);
        try {
            $key = json_decode($channel->params, true)['pay_public_key'];
            // Validate the signature
            $this->validatePaySignature($request, $key);
        } catch (Exception $exception) {
            throw new BadRequestHttpException;
        }
        return [
            'order_id' => $request->cp_order_id,
            'transaction_id' => $request->order_id,
            'amount' => $request->amount
        ];
    }

    /**
     * Sign.
     * 
     * @param $params
     * @param $key
     */
    protected function sign($params, $key)
    {
        $original = collect($params)->sortKeys()->implode('&');
        return hash_hmac('sha256', $original, $key);
    }

    /**
     * Determine if the given request has a valid signature.
     *
     * @param \Illuminate\Http\Request  $request
     * @param $key
     * @return bool
     */
    protected function validatePaySignature($request, $key)
    {
        $original = collect($request->except(['signature', 'token']))->sortKeys()->implode('&');       

        if (OpenSSL::verify($original, base64_decode($request->signature), $key) == 1) {
            return;
        }
        throw new InvalidSignatureException;
    }
}
