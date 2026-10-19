<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([

                        Section::make('Page Information')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Page Title')
                                    ->placeholder('Enter page title...')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn($state, callable $set) => $set('slug', Str::slug($state))
                                    )
                                    ->maxLength(255),
                                RichEditor::make('content')
                                    ->label('Content')
                                    ->required(),
                            ])
                            ->columnSpan(2),

                        Section::make('Settings')
                            ->schema([
                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->readOnly()
                                    ->dehydrated()
                                    ->prefix('https://filenewer.com/pages/')
                                    ->suffixAction(
                                        Action::make('copy')
                                            ->icon('heroicon-s-clipboard-document-check')
                                            ->tooltip('Copy URL')
                                            ->action(function ($livewire, $state) {
                                                $livewire->js(
                                                    'window.navigator.clipboard.writeText("https://filenewer.com/pages/' . $state . '");
                                                    $tooltip("Copied!", { timeout: 1500 });'
                                                );
                                            })
                                    ),
                                Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(true)
                                    ->helperText('Make page visible'),
                            ])
                            ->columnSpan(1),

                    ])
                    ->columnSpanFull(),
            ]);
    }
}
