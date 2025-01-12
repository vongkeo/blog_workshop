<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'title',
        'content',
        'image',
        'user_id',
        'category_id'
    ];

    // belong to user
    public function user()
    {
        // one to one
        return $this->belongsTo(User::class);
    }

    // belong to category
    public function category()
    {
        // one to one
        return $this->belongsTo(Category::class);
    }
}
