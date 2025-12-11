<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('first_name')
                            ->label('First Name')
                            ->placeholder('First Name')
                            ->required(),
                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->placeholder('Last Name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Email address')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->suffixIcon('heroicon-m-envelope')
                            ->required(),
                        PhoneInput::make('phone_number')
                            ->label('Phone No.')
                            ->placeholder('Phone number')
                            ->defaultCountry('in')
                            ->required()
                            ->countryStatePath('region_code'),
                        TextInput::make('country')
                            ->placeholder('Country')
                            ->label('Country')
                            ->autocomplete(false),
                        TextInput::make('city')
                            ->label('City')
                            ->placeholder('City')
                            ->autocomplete(false),
                        TextInput::make('designation')
                            ->label('Designation')
                            ->placeholder('Designation'),
                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->placeholder('Company Name'),
                        TextInput::make('website_url')
                            ->label('Website URL')
                            ->placeholder('Website URL')
                            ->suffixIcon('heroicon-m-globe-alt')
                            ->url(),
                        TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->placeholder('LinkedIn URL')
                            ->suffixIcon(new HtmlString('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"  fill="currentColor" class="fi-input-wrp-icon h-5 w-5 text-gray-400 dark:text-gray-500">
                                   <path d="M196.3 512L103.4 512L103.4 212.9L196.3 212.9L196.3 512zM149.8 172.1C120.1 172.1 96 147.5 96 117.8C96 103.5 101.7 89.9 111.8 79.8C121.9 69.7 135.6 64 149.8 64C164 64 177.7 69.7 187.8 79.8C197.9 89.9 203.6 103.6 203.6 117.8C203.6 147.5 179.5 172.1 149.8 172.1zM543.9 512L451.2 512L451.2 366.4C451.2 331.7 450.5 287.2 402.9 287.2C354.6 287.2 347.2 324.9 347.2 363.9L347.2 512L254.4 512L254.4 212.9L343.5 212.9L343.5 253.7L344.8 253.7C357.2 230.2 387.5 205.4 432.7 205.4C526.7 205.4 544 267.3 544 347.7L544 512L543.9 512z"/></svg>'))
                            ->url(),
                        TextInput::make('company_linkedin_url')
                            ->label('Company LinkedIn URL')
                            ->placeholder('Company LinkedIn URL')
                            ->suffixIcon(new HtmlString('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"  fill="currentColor" class="fi-input-wrp-icon h-5 w-5 text-gray-400 dark:text-gray-500">
                                   <path d="M196.3 512L103.4 512L103.4 212.9L196.3 212.9L196.3 512zM149.8 172.1C120.1 172.1 96 147.5 96 117.8C96 103.5 101.7 89.9 111.8 79.8C121.9 69.7 135.6 64 149.8 64C164 64 177.7 69.7 187.8 79.8C197.9 89.9 203.6 103.6 203.6 117.8C203.6 147.5 179.5 172.1 149.8 172.1zM543.9 512L451.2 512L451.2 366.4C451.2 331.7 450.5 287.2 402.9 287.2C354.6 287.2 347.2 324.9 347.2 363.9L347.2 512L254.4 512L254.4 212.9L343.5 212.9L343.5 253.7L344.8 253.7C357.2 230.2 387.5 205.4 432.7 205.4C526.7 205.4 544 267.3 544 347.7L544 512L543.9 512z"/></svg>'))
                            ->url(),
                        TextInput::make('apollo_id')
                            ->label('Apollo ID')
                            ->placeholder('Apollo ID'),
                        TextInput::make('company_apollo_id')
                            ->label('Company Apollo ID')
                            ->placeholder('Company Apollo ID'),
                        Textarea::make('notes')
                            ->label('Notes')
                            ->placeholder('Notes')
                            ->rows(2),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}
