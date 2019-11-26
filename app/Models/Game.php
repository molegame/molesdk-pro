<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pri_key',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'icon',
        'key',
        'secret',
        'pub_key',
        'pri_key',
        'pay_callback',
        'pay_callback_debug',
        'status'
    ];

    /**
     * A game may be given many developers.
     */
    public function developers(): BelongsToMany
    {
        return $this->belongsToMany(Developer::class, 'developer_has_games', 'game_id', 'developer_id');
    }

    /**
     * A game may has many channels.
     */
    public function channels(): HasMany
    {
        return $this->hasMany(Game\Channel::class);
    }
}
