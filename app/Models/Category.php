<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];


    public function posts()
    {
        // one to many
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        // one to one
        return $this->belongsTo(User::class);
    }
}
