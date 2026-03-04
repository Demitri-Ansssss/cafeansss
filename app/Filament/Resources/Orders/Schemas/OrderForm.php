<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->label('Pelanggan'),
                \Filament\Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Total Harga'),
                \Filament\Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'success' => 'Success',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('pending'),
                \Filament\Forms\Components\Select::make('payment_method')
                    ->options([
                        'cash' => 'Tunai/Cash',
                        'qris' => 'QRIS',
                    ])
                    ->required()
                    ->default('cash'),
            ]);
    }
}
