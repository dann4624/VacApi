<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoxLog extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "box_id",
        "log_action_id",
        "zone_id",
        "position_id",
        "user_id",
    ];

    protected $hidden = [
        "log_action_id",
        "box_id",
        "user_id",
        "zone_id",
        "position_id",
    ];

    protected $appends = [
        "log_action",
        "box",
        "user",
        "zone",
        "position",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function action()
    {
        return $this->belongsTo(LogAction::class,'log_action_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getlogactionAttribute()
    {
        return $this->action()->first();
    }

    public function getuserAttribute()
    {
        return $this->user()->first();
    }

    public function getboxAttribute()
    {
        return $this->box()->first()->makeHidden('logs');
    }

    public function getzoneAttribute()
    {
        return $this->zone()->first();
    }

    public function getpositionAttribute()
    {
        return $this->position()->first();
    }
}
