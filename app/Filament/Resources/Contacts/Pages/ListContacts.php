<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Contact'),

            ExportAction::make()->exports([
                ExcelExport::make()
                ->fromTable()
                ->withColumns([
                    Column::make('first_name'),
                    Column::make('last_name'),
                    Column::make('email'),
                    Column::make('region_code'),
                    Column::make('phone_number'),
                    Column::make('country'),
                    Column::make('city'),
                    Column::make('designation'),
                    Column::make('company_name'),
                    Column::make('tags')
                        ->formatStateUsing(fn($record) => $record->tags->pluck('name')->implode(', ')),
                    Column::make('products')
                        ->formatStateUsing(fn($record) => $record->products->pluck('name')->implode(', ')),
                ]),
            ]),
        ];
    }
}
