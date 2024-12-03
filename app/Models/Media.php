<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_path', 'type', 'mime_type', 'size'];

    // Accessor for full file URL
    public function getUrlAttribute()
    {
        return asset($this->file_path);
    }
}
