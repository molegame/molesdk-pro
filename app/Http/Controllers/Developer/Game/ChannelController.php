<?php

namespace App\Http\Controllers\Developer\Game;

use App\Http\Controllers\Controller;
use App\Http\Resources\Game\ChannelResource;
use App\Models\Game;
use App\Models\Game\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('developer');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  $game_id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $game_id)
    {
        $request->validate([
            'name' => 'string|max:255'
        ]);
        $game = $request->user()->games()->findOrFail($game_id);

        $channels = $game->channels();
        // Filter by params
        if ($request->filled('name')) {
            $name = $request->name;
            $channels_matched = Arr::where(config('channels'), function ($value) use ($name) {
                return strstr($value, $name) !== false ? true : false;
            });
            $channels = $channels->whereIn('channel_id', Arr::pluk($channels_matched, 'id'));
        }
        
        return ChannelResource::collection($channels->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $game_id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $game_id)
    {
        $request->validate([
            'channel_id' => 'required|integer'
        ]);
        $game = $request->user()->games()->findOrFail($game_id);
        
        $channel = $game->channels()->create([
            'game_id' => $game->id,
            'channel_id' => $request->channel_id
        ]);

        return ChannelResource::make($channel);
    }

    /**
     * Display the specified resource.
     *
     * @param  $game_id
     * @param  $channel_id
     * @return \Illuminate\Http\Response
     */
    public function show($game_id, $channel_id)
    {
        $game = $this->guard()->user()->games()->findOrFail($game_id);
        $channel = $game->channels()->where('channel_id', $channel_id)->first();
        return ChannelResource::make($channel);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $game_id
     * @param  $channel_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $game_id, $channel_id)
    {
        $request->validate([
            'bundle_id' => 'string|max:255',
            'icon' => 'string|max:255',
            'splashes' => 'string|max:255',
            'goods' => 'string|max:255',
            'params' => 'string|max:255',
        ]);

        $game = $this->guard()->user()->games()->findOrFail($game_id);
        
        $attributes = [];
        if ($request->has('bundle_id')) {
            $attributes['bundle_id'] = $request->bundle_id;
        }
        if ($request->has('icon')) {
            $attributes['icon'] = $request->icon;
        }
        if ($request->has('splashes')) {
            $attributes['splashes'] = $request->splashes;
        }
        if ($request->has('goods')) {
            $attributes['goods'] = $request->goods;
        }
        if ($request->has('params')) {
            $attributes['params'] = $request->params;
        }
        $game->channels()->where('channel_id', $channel_id)->update($attributes);

        return response()->json([
            'message' => trans('success'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $game_id
     * @param  $channel_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($game_id, $channel_id)
    {
        $game = $this->guard()->user()->games()->findOrFail($game_id);
        $game->channels()->where('channel_id', $channel_id)->delete();
        
        return response()->json([
            'message' => trans('success'),
            'status_code' => 200
        ], 200);
    }
}
