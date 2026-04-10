<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tool extends Model
{
    use HasSlug;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'order',
        'category_id',
        'title',
        'body',
        'tags'
    ];


    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}

