<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('author_id')
                    ->required()
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('isbn')
                    ->required(),
                TextInput::make('published_year'),
                TextInput::make('total_copies')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('available_copies')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->image(),
            ]);
    }
}
