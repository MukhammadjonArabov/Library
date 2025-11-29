<?php

namespace App\Filament\Resources\Borrowings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BorrowingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('book_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('borrower_name')
                    ->required(),
                TextInput::make('borrower_phone')
                    ->tel(),
                DatePicker::make('borrowed_at')
                    ->required(),
                DatePicker::make('due_date')
                    ->required(),
                DatePicker::make('returned_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
