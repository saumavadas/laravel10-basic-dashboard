<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'meta_key', 'meta_value'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
