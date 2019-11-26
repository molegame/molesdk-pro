<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Http\Resources\GameResource;
use App\Utils\OpenSSL;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * The length of key between sdk client and sdk server
     */
    const KEY_LENGTH = 16;
    /**
     * The length of secret betten game server and sdk server
     */
    const SECRET_LENGTH = 32;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'integer',
            'name' => 'string|max:255'
        ]);

        $games = $request->user()->games();
        // Wheter is to fetch trashed
        if ($request->has('trashed')) {
            $games = $games->onlyTrashed();
        }
        // Filter by params
        if ($request->filled('type')) {
            $games = $games->where('type', $request->type);
        }
        if ($request->filled('name')) {
            $games = $games->where('name', 'like', '%'.$request->name.'%');
        }

        return GameResource::collection($games->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $developer = $request->user();
        $params = $request->all();

        $request->validate([
            'type' => 'required|integer',
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'pay_callback' => 'nullable|string|max:255',
            'pay_callback_debug' => 'nullable|string|max:255',
        ]);

        $pem = OpenSSL::newKey();
        $game = $developer->games()->create([
            'type' => $params['type'],
            'name' => $params['name'],
            'icon' => $params['icon'],
            'pay_callback' => $params['pay_callback'],
            'pay_callback_debug' => $params['pay_callback'],
            'key' => Str::random(self::KEY_LENGTH),
            'secret' => Str::random(Self::SECRET_LENGTH),
            'pub_key' => OpenSSL::getPublicKey($pem),
            'pri_key' => OpenSSL::getPrivateKey($pem)
        ]);

        return GameResource::make($game);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = $this->guard()->user()->games()->findOrFail($id);
        return GameResource::make($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'integer',
            'name' => 'string|max:255',
            'icon' => 'string|max:255',
            'pay_callback' => 'nullable|string|max:255',
            'pay_callback_debug' => 'nullable|string|max:255',
        ]);

        $game = $request->user()->games()->findOrFail($id);

        if ($request->filled('type')) {
            $game->type = $request->type;
        }
        if ($request->filled('name')) {
            $game->name = $request->name;
        }
        if ($request->filled('icon')) {
            $game->icon = $request->icon;
        }
        if ($request->has('pay_callback_debug')) {
            $game->pay_callback_debug = $request->pay_callback_debug;
        }
        if ($request->has('pay_callback_debug')) {
            $game->pay_callback_debug = $request->pay_callback_debug;
        }
        $game->save();

        return response()->json([
            'message' => trans('success'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = $this->guard()->user()->games()->findOrFail($id);
        $game->delete();
        
        return response()->json([
            'message' => trans('success'),
            'status_code' => 200
        ], 200);
    }

    /**
     * Restore a soft-deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $game = $this->guard()->user()->games()->onlyTrashed()->findOrFail($id);
        $game->restore();
        
        return response()->json([
            'message' => trans('success'),
            'status_code' => 200
        ], 200);
    }
}
