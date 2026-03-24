<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'excerpt',
        'featured_image',
        'is_published',
        'published_at',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tools(){
        return $this->belongsToMany(Tool::class, 'blog_tool');
    }
}
