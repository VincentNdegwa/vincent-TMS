<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'assigner',
        "user_id",
        "description",
        'due_date',
        'unique_id',
        'completed',
        'task_reply',
        'date_submit',
        'priority',
        'taskFile',
        'response_file'
    ];
    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function assigner()
    {
        return $this->belongsTo(User::class, 'assigner');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comments::class);
    }

    public function taskComments()
    {
        return $this->hasMany(Comments::class);
    }
}
