<?php

namespace App\Models;

use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasContentTranslations;

    public const TRANSLATABLE_CONTENT = ['title' => 'text', 'description' => 'textarea'];

    protected $fillable = ['title', 'icon', 'description', 'slug', 'title_translations', 'description_translations'];

    protected function casts(): array
    {
        return ['title_translations' => 'array', 'description_translations' => 'array'];
    }

    public function tools()
    {
        return $this->hasMany(Tool::class);
    }
}
