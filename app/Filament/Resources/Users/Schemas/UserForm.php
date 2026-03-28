<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('provider_id'),
                TextInput::make('provider'),
                TextInput::make('join_date'),
                TextInput::make('last_login'),
                TextInput::make('phone_number')
                    ->tel(),
                TextInput::make('status'),
                TextInput::make('role_name'),
                TextInput::make('avatar'),
                TextInput::make('position'),
                TextInput::make('department'),
                TextInput::make('line_manager'),
                TextInput::make('seconde_line_manager'),
            ]);
    }
}
