<?php

namespace App\Sdk\Drivers;

use RuntimeException;
use App\Sdk\SdkDriver;
use App\Models\Game\Channel;
use App\Models\Game;
use GuzzleHttp\Client;

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
            Log::debug(sprintf("Verify failed from channel %s.", $channel->channel_id));
            return;
        }
        $data = json_decode($res->getBody(), true);

        return $data['openid'];
    }

    /**
     * Callback after paid.
     * @param Channel $channel
     * @param Game $game
     * @param Request $request
     */
    public function callback(Request $request, Channel $channel, Game $game)
    {

    }

    /**
     * @param $params
     */
    protected function sign($params, $key)
    {
        $original = collect($params)->sortKeys()->implode('&');
        return hash_hmac('sha256', $original, $key);
    }
}
