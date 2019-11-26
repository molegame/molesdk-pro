<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * A player may has many orders.
     */
    public function orders()
    {
        return $this->hasMany(App\Models\Order::class, 'id', 'player_id');
    }
}
