<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groupMessage extends Model
{
    protected $table = "group_messages";
    use HasFactory;
    protected $fillable = [
        'message',
        'user_id',
        "group_id"
    ];

    function users()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
