<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
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
                                        fn($state, callable $set) =>
                                        $set('slug', Str::slug($state))
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
                                    ->label('URL')
                                    ->readOnly()
                                    ->copyable()
                                    ->afterStateHydrated(function ($component, $state) {
                                        $component->state('https://filenewer.com/pages/' . $state);
                                    }),
                                Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(true)
                                    ->helperText('Make page visible'),
                            ])->columnSpan(1),

                    ])->columnSpanFull()




            ]);
    }
}
