<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "position_id",
        "type_id"
    ];

    protected $appends = [
        'type',
        'position',
        'logs'
    ];

    protected $hidden = [
        'type_id',
        'position_id'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function logs()
    {
        return $this->hasMany(BoxLog::class);
    }

    public function gettypeAttribute()
    {
        return $this->type()->first();
    }

    public function getpositionAttribute()
    {
        return $this->position()->first()->makeHidden('box');
    }

    public function getlogsAttribute()
    {
        return $this->logs()->get()->makeHidden('box');
    }
}
