<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model
{
    use HasContentTranslations;
    use HasSlug;

    public const TRANSLATABLE_CONTENT = ['title' => 'text', 'excerpt' => 'textarea', 'content' => 'rich', 'category' => 'text'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'excerpt',
        'featured_image',
        'is_published',
        'published_at',
        'user_id',
        'title_translations',
        'excerpt_translations',
        'content_translations',
        'category_translations',
    ];

    protected function casts(): array
    {
        return ['title_translations' => 'array', 'excerpt_translations' => 'array', 'content_translations' => 'array', 'category_translations' => 'array'];
    }

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

    public function tools()
    {
        return $this->belongsToMany(Tool::class, 'blog_tool');
    }
}
