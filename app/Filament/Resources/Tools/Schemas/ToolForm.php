<?php

namespace App\Filament\Resources\Tools\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ToolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([

                        Section::make('Tool Information')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Tool Name')
                                    ->placeholder('Enter tool name...')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn($state, callable $set) =>
                                        $set('slug', Str::slug($state))
                                    )
                                    ->maxLength(255),

                                TextInput::make('title')
                                    ->label('SEO Title')
                                    ->placeholder('Enter tool title...')
                                    ->required()
                                    ->maxLength(255),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->placeholder('Enter tool description...')
                                    ->rows(3),

                                TagsInput::make('tags')
                                    ->label(__("Keywords"))
                                    ->placeholder("SEO Keywords")
                                    ->separator(',', ','),

                                RichEditor::make('body')
                                    ->label(__("Content")),
                            ])
                            ->columnSpan(2),

                        Section::make('Settings')

                            ->schema([

                                Select::make('category')
                                    ->relationship('category', 'title')
                                    ->label(__("Category"))
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('icon')
                                    ->label('Icon')
                                    ->placeholder('e.g. heroicon-o-wrench'),



                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->readOnly()
                                    ->prefix('https://filenewer.com/tools/')
                                    ->suffixAction(
                                        Action::make('copy')
                                            ->icon('heroicon-s-clipboard-document-check')
                                            ->tooltip('Copy URL')
                                            ->action(function ($livewire, $state) {
                                                $livewire->js(
                                                    'window.navigator.clipboard.writeText("https://filenewer.com/tools/' . $state . '");
                     $tooltip("Copied!", { timeout: 1500 });'
                                                );
                                            })
                                    ),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Make tool visible'),
                            ])
                            ->columnSpan(1),

                    ])->columnSpanFull(),
            ]);
    }
}
