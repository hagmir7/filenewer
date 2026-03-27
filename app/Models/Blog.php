<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasSlug;


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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tools(){
        return $this->belongsToMany(Tool::class, 'blog_tool');
    }
}
