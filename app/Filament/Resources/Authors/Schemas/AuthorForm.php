<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('surname')
                    ->required(),
                DatePicker::make('birth_date'),
                Textarea::make('bio')
                    ->columnSpanFull(),
            ]);
    }
}
