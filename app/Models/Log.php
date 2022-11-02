<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "user_id",
        "log_action_id",
        "data",
    ];

    protected $hidden = [
        "user_id",
        "log_action_id",
    ];

    protected $appends = [
        "user",
        "log_action",
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
        'deleted_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function action()
    {
        return $this->belongsTo(LogAction::class,'log_action_id');
    }

    public function getlogactionAttribute()
    {
        return $this->action()->first();
    }

    public function getuserAttribute()
    {
        return $this->user()->first();
    }
}
