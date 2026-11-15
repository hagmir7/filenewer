<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasContentTranslations;
    use HasSlug;

    public const TRANSLATABLE_CONTENT = ['title' => 'text', 'description' => 'textarea', 'content' => 'rich'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'description',
        'is_published',
        'title_translations',
        'description_translations',
        'content_translations',
    ];

    protected function casts(): array
    {
        return ['title_translations' => 'array', 'description_translations' => 'array', 'content_translations' => 'array'];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }
}
