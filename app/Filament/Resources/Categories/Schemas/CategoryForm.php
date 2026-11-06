<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),

                Textarea::make('icon')
                    ->label('Icon (SVG code)')
                    ->placeholder('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">...</svg>')
                    ->rows(6)
                    ->live(debounce: 500)
                    ->extraInputAttributes(['dir' => 'ltr', 'spellcheck' => 'false'])
                    ->rule(fn(): \Closure => function (string $attribute, $value, \Closure $fail) {
                        if (filled($value) && ! preg_match('/^\s*<svg[\s>].*<\/svg>\s*$/is', $value)) {
                            $fail('The icon must be valid SVG code (<svg ...>...</svg>).');
                        }
                    })
                    ->dehydrateStateUsing(fn(?string $state): ?string => filled($state) ? self::sanitizeSvg($state) : null)
                    ->columnSpanFull(),

                Text::make(fn(Get $get): HtmlString => new HtmlString(
                    '<div style="width:4rem;height:4rem;">' . self::sanitizeSvg((string) $get('icon')) . '</div>'
                ))
                    ->visible(fn(Get $get): bool => filled($get('icon')))
                    ->columnSpanFull(),
            ]);
    }

    public static function sanitizeSvg(string $svg): string
    {
        $svg = trim($svg);

        // Remove script-like elements
        $svg = preg_replace('/<(script|foreignObject|iframe|object|embed)\b[^>]*>.*?<\/\1>/is', '', $svg);
        $svg = preg_replace('/<(script|foreignObject|iframe|object|embed)\b[^>]*\/?>/is', '', $svg);

        // Remove inline event handlers (onclick, onload, ...)
        $svg = preg_replace('/\son\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $svg);

        // Remove javascript: URLs
        $svg = preg_replace('/\s(?:xlink:)?href\s*=\s*("|\')\s*javascript:[^"\']*\1/i', '', $svg);

        return $svg;
    }
}
