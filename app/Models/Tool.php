<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tool extends Model
{
    use HasContentTranslations;
    use HasSlug;

    public const TRANSLATABLE_CONTENT = ['name' => 'text', 'title' => 'text', 'description' => 'textarea', 'body' => 'rich', 'tags' => 'tags'];

    protected $fillable = [
        'name',
        'name_translations',
        'slug',
        'description',
        'description_translations',
        'icon',
        'is_active',
        'order',
        'category_id',
        'title',
        'title_translations',
        'body',
        'body_translations',
        'tags',
        'tags_translations',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'name_translations' => 'array',
            'title_translations' => 'array',
            'tags_translations' => 'array',
            'description_translations' => 'array',
            'body_translations' => 'array',
        ];
    }

    public function localizedDescription(?string $locale = null): ?string
    {
        return $this->localized('description', $locale);
    }

    public function localizedBody(?string $locale = null): ?string
    {
        return $this->localized('body', $locale);
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
