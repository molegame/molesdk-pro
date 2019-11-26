<?php

namespace App\Models\Game;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'game_channels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'bundle_id',
        'icon',
        'splashes',
        'goods',
        'params',
    ];

    /**
     * Get the game that owns the config.
     */
    public function game()
    {
        return $this->belongsTo(App\Models\Game::class);
    }
}
