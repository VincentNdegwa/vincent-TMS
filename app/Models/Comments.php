<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'task_id',
        'sender_id',
    ];

    public function myTasks(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }


    public function Sender()
    {
        return $this->belongsTo(User::class, "sender_id", "id");
    }
}
