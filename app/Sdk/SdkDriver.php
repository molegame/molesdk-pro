<?php

namespace App\Sdk;

use Illuminate\Http\Request;
use App\Models\Game\Channel;
use App\Models\Game;

interface SdkDriver
{
    /**
     * To theck if the token is valid.
     *
     * @param Channel $channel
     * @param  string  $token
     * @return string
     */
    public function verify(Channel $channel, $token);

    /**
     * Callback after paid.
     * @param Channel $channel
     * @param Game $game
     * @param Request $request
     */
    //public function callback(Request $request, Channel $channel, Game $game);
}
