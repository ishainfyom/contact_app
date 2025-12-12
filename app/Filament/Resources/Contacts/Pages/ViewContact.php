<?php

namespace App\Filament\Resources\Contacts\Pages;

use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\Contacts\Widgets\ContactProducts;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->url(ContactResource::getUrl('index')),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextEntry::make('full_name')
                            ->label('Name:'),
                        TextEntry::make('email')
                            ->label('Email:'),
                        TextEntry::make('phone_number')
                            ->label('Phone:'),
                        TextEntry::make('designation')
                            ->label('Designation:')
                            ->default('N/A'),
                        TextEntry::make('company_name')
                            ->label('Company Name:')
                            ->default('N/A'),
                        TextEntry::make('website_url')
                            ->label('Website URL:')
                            ->url(fn ($state) => $state && $state != 'N/A' ? $state : null)
                            ->openUrlInNewTab()
                            ->default('N/A'),
                        TextEntry::make('linkedin_url')
                            ->label('LinkedIn URL:')
                            ->url(fn ($state) => $state && $state != 'N/A' ? $state : null)
                            ->openUrlInNewTab()
                            ->default('N/A'),
                        TextEntry::make('company_linkedin_url')
                            ->label('Company LinkedIn URL:')
                            ->url(fn ($state) => $state && $state != 'N/A' ? $state : null)
                            ->openUrlInNewTab()
                            ->default('N/A'),
                        TextEntry::make('apollo_id')
                            ->label('Apollo ID:')
                            ->default('N/A'),
                        TextEntry::make('company_apollo_id')
                            ->label('Company Apollo ID:')
                            ->default('N/A'),
                        TextEntry::make('city')
                            ->label('City:')
                            ->default('N/A'),
                        TextEntry::make('country')
                            ->label('Country:')
                            ->default('N/A'),
                        TextEntry::make('notes')
                            ->label('Notes:')
                            ->default('N/A'),
                    ])
                    ->columns(3)->columnSpanFull(),
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Products')
                            ->schema([
                                Livewire::make(ContactProducts::class, ['contact_id' => $this->record->id]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
