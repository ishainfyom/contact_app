<?php

namespace App\Filament\Resources\Products\Tables;

use App\Filament\Resources\Products\Pages\ViewProduct;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('')
                    ->iconButton()
                    ->tooltip('View')
                    ->url(fn($record) => ViewProduct::getUrl(['record' => $record])),
                EditAction::make()
                    ->label('')
                    ->iconButton()
                    ->tooltip('Edit')
                    ->modalWidth('md')
                    ->modalHeading('Edit Product')
                    ->successNotificationTitle('Product updated successfully'),
                DeleteAction::make()
                    ->label('')
                    ->iconButton()
                    ->tooltip('Delete'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->actionsColumnLabel('Actions');
    }
}
