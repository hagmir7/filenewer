<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('provider_id')
                    ->placeholder('-'),
                TextEntry::make('provider')
                    ->placeholder('-'),
                TextEntry::make('join_date')
                    ->placeholder('-'),
                TextEntry::make('last_login')
                    ->placeholder('-'),
                TextEntry::make('phone_number')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->placeholder('-'),
                TextEntry::make('role_name')
                    ->placeholder('-'),
                TextEntry::make('avatar')
                    ->placeholder('-'),
                TextEntry::make('position')
                    ->placeholder('-'),
                TextEntry::make('department')
                    ->placeholder('-'),
                TextEntry::make('line_manager')
                    ->placeholder('-'),
                TextEntry::make('seconde_line_manager')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
