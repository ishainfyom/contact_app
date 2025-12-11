<?php

namespace App\Filament\Resources\Contacts\Widgets;

use App\Models\Contact;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class ContactProducts extends TableWidget
{
    public ?int $contact_id = null;

    protected function getTableHeading(): string
    {
        return '';
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(function () {
                if ($this->contact_id) {
                    $contact = Contact::find($this->contact_id);
                    if ($contact) {
                        return $contact->products();
                    }
                }

                return null;
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('pivot.hosted_url')
                    ->label('Hosted URL')
                    ->url(fn ($record) => $record->pivot->hosted_url)
                    ->openUrlInNewTab()
                    ->default('N/A')
                    ->limit(30),
                TextColumn::make('pivot.autodesk')
                    ->label('Autodesk')
                    ->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                TextColumn::make('pivot.envato_username')
                    ->label('Envato Username')
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
