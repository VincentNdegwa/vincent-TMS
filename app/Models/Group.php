<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $fillable = [
        "group_name",
        "group_description",
        "group_icon"
    ];

    public function user_group()
    {
        return $this->hasMany(UserGroup::class);
    }
}
