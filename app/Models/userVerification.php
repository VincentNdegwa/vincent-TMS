<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userVerification extends Model
{
    use HasFactory;
    protected $table = 'user_verification';

    protected $fillable = [
        'verificationToken',
        'user_id',
        'userName',
        "userEmail",
        'startVerification',
        'expireVerification',
        'emailStatus',
    ];
}
