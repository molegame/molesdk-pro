<?php

namespace App\Sdk;

use Illuminate\Support\Manager;
use App\Models\Game\Channel;
use App\Models\Game;

class SdkManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        
    }

    /**
     * Create an instance of the Mole sdk Driver.
     *
     * @return Drivers\Mole
     */
    public function createMoleDriver()
    {
        return new Drivers\Mole();
    }

    /**
     * Create an instance of the UC sdk Driver.
     *
     * @return Drivers\UC
     */
    public function createUCDriver()
    {
        
    }

    /**
     * To theck if the token is valid.
     *
     * @param  string  $token
     * @return string
     */
    public function verify($channel, $token)
    {
        $driver = $channel->info()['driver'];
        
        return $this->driver($driver)->verify($channel, $token);
    }

    /**
     * Callback after paid.
     *
     * @param Request $request
     */
    public function callback(Request $request, $channel_id, $game_id)
    {
        $driver = config('channels')[$channel_id]['driver'];
        $channel = Channel::findOrFail($channel_id);
        $game = Game::findOrFail($game_id);

        return $this->driver($driver)->callback($request, $channel, $game);
    }
}
