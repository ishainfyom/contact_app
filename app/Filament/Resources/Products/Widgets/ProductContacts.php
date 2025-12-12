<?php

namespace App\Filament\Resources\Products\Widgets;

use App\Models\Product;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class ProductContacts extends TableWidget
{
    public ?int $product_id = null;

    protected function getTableHeading(): string
    {
        return 'Contacts Details';
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(function () {
                if ($this->product_id) {
                    $product = Product::find($this->product_id);
                    if ($product) {
                        return $product->contacts();
                    }
                }

                return null;
            })
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                PhoneColumn::make('phone_number')
                    ->label('Phone')
                    ->countryColumn('region_code')
                    ->displayFormat(PhoneInputNumberType::INTERNATIONAL)
                    ->sortable(),
                TextColumn::make('company_name')
                    ->label('Company Name')
                    ->default('N/A'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
