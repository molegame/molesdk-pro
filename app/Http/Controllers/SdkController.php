<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SdkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $channel_id
     * @param $game_id
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request, $channel_id, $game_id)
    {
        return \Sdk::callback($request, $channel_id, $game_id);
    }
}
