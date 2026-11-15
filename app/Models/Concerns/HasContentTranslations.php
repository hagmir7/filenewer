<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasContentTranslations
{
    public function localized(string $attribute, ?string $locale = null): string|array|null
    {
        $type = static::TRANSLATABLE_CONTENT[$attribute] ?? throw new \InvalidArgumentException("{$attribute} is not translatable.");
        $locale ??= app()->getLocale();
        $translations = $this->getAttribute($attribute.'_translations') ?? [];

        foreach (array_unique([$locale, config('app.fallback_locale')]) as $language) {
            $translation = $translations[$language] ?? null;

            if ($type === 'tags') {
                $tags = $this->normalizeTags($translation);

                if ($tags !== []) {
                    return $tags;
                }

                continue;
            }

            if (! is_string($translation)) {
                continue;
            }

            $text = html_entity_decode(strip_tags($translation), ENT_QUOTES | ENT_HTML5, 'UTF-8');

            if (Str::squish($text) !== '' || ($type === 'rich' && preg_match('/<(img|video|audio|iframe|figure|table|hr)\b/i', $translation))) {
                return $translation;
            }
        }

        $original = $this->getAttribute($attribute);

        if ($type === 'tags') {
            return array_map(fn (string $tag): string => __($tag, [], $locale), $this->sourceTags());
        }

        if ($original === null || $type === 'rich') {
            return $original;
        }

        return __($attribute === 'description' ? Str::squish($original) : $original, [], $locale);
    }

    public function sourceTags(): array
    {
        return $this->normalizeTags($this->getAttribute('tags') ?? ($this->getAttributes()['tags'] ?? null));
    }

    private function normalizeTags(mixed $tags): array
    {
        if (is_string($tags)) {
            $tags = explode(',', $tags);
        }

        if (! is_array($tags)) {
            return [];
        }

        return array_values(array_filter(array_map(fn (mixed $tag): string => is_string($tag) ? trim($tag) : '', $tags), fn (string $tag): bool => $tag !== ''));
    }
}
