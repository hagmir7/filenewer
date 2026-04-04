<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([

                        Section::make('Blog Information')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Blog Title')
                                    ->placeholder('Enter blog title...')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn($state, callable $set) =>
                                        $set('slug', Str::slug($state))
                                    )
                                    ->maxLength(255),

                                Textarea::make('excerpt')
                                    ->label('Excerpt')
                                    ->placeholder('Short summary...'),

                                RichEditor::make('content')
                                    ->label('Content')
                                    ->required(),
                            ])
                            ->columnSpan(2),

                        Section::make()
                            ->schema([
                                FileUpload::make('featured_image')
                                    ->label('Featured Image')
                                    ->image(),

                                TextInput::make('category')
                                    ->label('Category'),
                                DateTimePicker::make('published_at')
                                    ->native(false)
                                    ->label('Publish Date'),
                                Toggle::make('is_published')
                                    ->label('Published')

                                    ->default(false)
                                    ->helperText('Make blog post visible')
                                    ->required(),
                            ])
                            ->columnSpan(1),

                    ])->columnSpanFull(),
            ]);
    }
}
