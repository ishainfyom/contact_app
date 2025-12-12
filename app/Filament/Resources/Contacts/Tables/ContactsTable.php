<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Tag;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('first_name')
                    ->label('Name')
                    ->formatStateUsing(fn($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('last_name')
                    ->hidden(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                PhoneColumn::make('region_code')
                    ->hidden(),
                PhoneColumn::make('phone_number')
                    ->label('Phone')
                    ->countryColumn('region_code')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('country')
                    ->label('Country')
                    ->options(function () {
                        return array_filter(Contact::all()->pluck('country', 'country')->map(function ($country) {
                            return $country;
                        })->unique()->toArray() ?? []);
                    })
                    ->searchable()
                    ->native(false),

                SelectFilter::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->native(false),

                SelectFilter::make('products')
                    ->label('Products')
                    ->relationship('products', 'name')
                    ->multiple()
                    ->native(false),
            ])
            ->deferFilters(false)
            ->recordActions([
                ViewAction::make()
                    ->label('')
                    ->iconButton(),
                Action::make('assignTags')
                    ->label('')
                    ->icon('heroicon-o-tag')
                    ->iconButton()
                    ->tooltip('Assign Tags')
                    ->form([
                        Select::make('tags')
                            ->label('Select Tags')
                            ->options(Tag::pluck('name', 'id')->toArray())
                            ->multiple()
                            ->required()
                            ->default(fn(Contact $record): array => $record->tags->pluck('id')->toArray()),
                    ])
                    ->action(function (array $data, Contact $record) {
                        if (! empty($data['tags']) && is_array($data['tags'])) {
                            $record->tags()->sync($data['tags']);

                            Notification::make()
                                ->title('Tags Assigned Successfully')
                                ->success()
                                ->send();
                        }
                    })
                    ->modalHeading('Assign Tags to Contact')
                    ->modalWidth('md'),
                Action::make('assignProducts')
                    ->label('')
                    ->icon('heroicon-o-squares-2x2')
                    ->iconButton()
                    ->tooltip('Assign Products')
                    ->modalHeading('Assign Products to Contact')
                    ->modalWidth('md')
                    ->form([
                        Select::make('product_id')
                            ->label('Products')
                            ->required()
                            ->native(false)
                            ->options(Product::pluck('name', 'id'))
                            ->default(fn(Contact $record) => $record->products->first()?->id),

                        TextInput::make('hosted_url')
                            ->label('Hosted URL')
                            ->url()
                            ->default(function (Contact $record) {
                                $firstProduct = $record->products->first();

                                return $firstProduct ? $firstProduct->pivot->hosted_url : '';
                            }),

                        Radio::make('autodesk')
                            ->label('Autodesk?')
                            ->boolean()
                            ->inline()
                            ->default(function (Contact $record) {
                                $firstProduct = $record->products->first();

                                return $firstProduct ? (bool) $firstProduct->pivot->autodesk : false;
                            }),

                        TextInput::make('envato_username')
                            ->label('Envato Username')
                            ->default(function (Contact $record) {
                                $firstProduct = $record->products->first();

                                return $firstProduct ? $firstProduct->pivot->envato_username : '';
                            }),

                        TextInput::make('envato_key')
                            ->label('Envato Key')
                            ->password()
                            ->default(function (Contact $record) {
                                $firstProduct = $record->products->first();

                                return $firstProduct ? $firstProduct->pivot->envato_key : '';
                            })
                            ->revealable(),
                    ])
                    ->action(function (array $data, Contact $record) {
                        $pivotData = [];

                        $productId = $data['product_id'];
                        $pivotData[$productId] = [
                            'hosted_url' => $data['hosted_url'] ?? null,
                            'autodesk' => $data['autodesk'] ?? false,
                            'envato_username' => $data['envato_username'] ?? null,
                            'envato_key' => $data['envato_key'] ?? null,
                        ];

                        $record->products()->sync($pivotData);

                        Notification::make()
                            ->title('Product Assigned Successfully.')
                            ->success()
                            ->send();
                    }),
                EditAction::make()
                    ->label('')
                    ->iconButton()
                    ->tooltip('Edit'),
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
