<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Model
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = [
        'name', 'email', 'profile_image', 'phone', 'otp', 'otp_verified_at',
    ];

    protected $hidden = ['otp'];
}
