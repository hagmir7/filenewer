<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Str;

class TranslationTabs
{
    public static function make(array $fields, array $maxLengths = []): Tabs
    {
        return Tabs::make('Translations')
            ->tabs(collect(config('app.supported_locales'))
                ->except('en')
                ->map(fn (array $language, string $locale): Tab => Tab::make($language['name'])
                    ->schema(collect($fields)->map(function (string $type, string $attribute) use ($locale, $language, $maxLengths) {
                        $name = $attribute.'_translations.'.$locale;
                        $field = match ($type) {
                            'rich' => RichEditor::make($name),
                            'textarea' => Textarea::make($name)->rows(3),
                            'tags' => TagsInput::make($name)->splitKeys([',', 'Enter', '،']),
                            default => TextInput::make($name)->maxLength(255),
                        };

                        if (isset($maxLengths[$attribute])) {
                            $field->maxLength($maxLengths[$attribute]);
                        }

                        return $field->label(Str::headline($attribute === 'body' ? 'content' : $attribute))
                            ->extraInputAttributes(['dir' => $language['direction'], 'lang' => $language['language']])
                            ->helperText('Leave blank to use the default English content.');
                    })->all()))
                ->all())
            ->columnSpanFull();
    }
}
