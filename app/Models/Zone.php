<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
    ];

    protected $appends = [
        'types',
        'positions_amount',
        'boxes_amount',
        'available_amount',
        'latest_log'
    ];

    /*
     * Relationer til andre Modeller / Tabeller
     */
    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class,'zone_type');
    }

    public function logs()
    {
        return $this->hasMany(ZoneLog::class);
    }

    public function boxes()
    {
        return $this->hasManyThrough(Box::class,Position::class);
    }

    public function getavailableAmountAttribute()
    {
        return count($this->positions()->get()) - count($this->boxes()->get());
    }

    public function getboxesAmountAttribute()
    {
        return count($this->boxes()->get());
    }

    public function getpositionsAmountAttribute()
    {
        return count($this->positions()->get());
    }

    public function gettypesAttribute()
    {
        return $this->types()->get();
    }

    public function getlatestLogAttribute()
    {
        $data = ZoneLog::where('zone_id','=',$this->id)
            ->orderby('created_at', 'desc')
            ->with('action')
            ->first();

        return $data;
    }
}
