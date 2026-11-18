<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'title'];

    public function url(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
