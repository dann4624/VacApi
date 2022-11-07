<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZoneLog extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "zone_id",
        "log_action_id",
        "temperature",
        "humidity",
        "alarm",
    ];

    protected $hidden = [
        "zone_id",
        "log_action_id",
    ];

    protected $appends = [
        "zone",
        "log_action",
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function action()
    {
        return $this->belongsTo(LogAction::class,'log_action_id');
    }


    public function getzoneAttribute()
    {
        return $this->zone()->first()->makeHidden('latest_log');
    }

    public function getlogactionAttribute()
    {
        return $this->action()->first();
    }
}
