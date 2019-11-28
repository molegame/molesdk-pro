<?php

namespace App\Sdk;

use Illuminate\Http\Request;
use App\Models\Game\Channel;

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
     * Validate callback of pay.
     * 
     * @param Channel $channel
     * @param Request $request
     */
    public function validatePay(Request $request, Channel $channel);
}
