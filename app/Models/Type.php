<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "name",
        "shelf_life",
        "minimum_temperature",
        "maximum_temperature",
    ];
}
