<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Laravue\Faker;
use \App\Laravue\JsonResponse;

class ChannelController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', self::ITEM_PER_PAGE);

        $channels = config('channels');

        $items = array_slice($channels, $page - 1, $limit);
        $total = count($channels);
        
        return [
            'items' => $items,
            'total' => $total
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $channels = config('channels');
        $channel = null;

        foreach($channels as $value) {
            if ($value['id'] != $id) {
                continue;
            }
            $channel = $value;
            break;
        }
        return $channel;
    }
}
