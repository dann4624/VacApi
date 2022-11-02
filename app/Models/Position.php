<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "zone_id",
        "box_id",
    ];

    protected $hidden = [
        "zone_id",
        "box_id",
    ];

    protected $appends = [
        "zone",
        "box"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'deleted_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function getzoneAttribute()
    {
        return $this->zone()->first();
    }

    public function getboxAttribute()
    {
        return $this->box()->first();
    }
}
