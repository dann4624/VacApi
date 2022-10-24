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

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'deleted_at' => 'datetime:d-m-Y H:i:s',
    ];

    /*
     * Relationer til andre Modeller / Tabeller
     */
    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }

    public function logs()
    {
        return $this->hasMany(BoxLog::class);
    }
}
