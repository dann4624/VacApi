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
        "shelf_id",
        "type_id"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'deleted_at' => 'datetime:d-m-Y H:i:s',
        'expires_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function shelf()
    {
        return $this->belongsTo(Shelf::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function logs()
    {
        return $this->hasMany(BoxLog::class);
    }
}
