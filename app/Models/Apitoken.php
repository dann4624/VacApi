<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apitoken extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "token",
        "target_id",
        "role_id",
        "expires_at",
    ];

    protected $hidden = [
        'target_id',
        'role_id'
    ];

    protected $appends = [
        'target',
        'role'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function target()
    {
        return $this->belongsTo(Apitarget::class);
    }

    public function gettargetAttribute()
    {
        return $this->target()->first();
    }

    public function getroleAttribute()
    {
        return $this->role()->first();
    }
}
