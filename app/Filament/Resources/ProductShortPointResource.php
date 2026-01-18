<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductShortPointResource\Pages;
use App\Models\ProductShortPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductShortPointResource extends Resource
{
    protected static ?string $model = ProductShortPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    
    protected static ?string $navigationGroup = 'Каталог';
    
    protected static ?string $navigationLabel = 'Короткі характеристики товару';
    
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'attribute_data->name->value->en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->translateAttribute('name'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Товар')
                    ->columnSpanFull()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('short_specs', [])),
                    
                Forms\Components\Repeater::make('short_specs')
                    ->schema([
                        Forms\Components\Hidden::make('id'),
                        Forms\Components\Tabs::make('Переклади')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('EN')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Назва (EN)')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('value_en')
                                            ->label('Значення (EN)')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Forms\Components\Tabs\Tab::make('UK')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_uk')
                                            ->label('Назва (UK)')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('value_uk')
                                            ->label('Значення (UK)')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                            ])
                    ])
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['name_en'] ?? null)
                    ->columnSpanFull()
                    ->defaultItems(1)
                    ->addActionLabel('Додати специфікацію')
                    ->deleteAction(
                        fn (Forms\Components\Actions\Action $action) => $action
                            ->requiresConfirmation()
                    ),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.attribute_data.name.value.en')
                    ->label('Товар')
                    ->formatStateUsing(fn ($record) => $record->product->translateAttribute('name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name.en')
                    ->label('Назва (EN)')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('value.en')
                    ->label('Значення')
                    ->limit(40),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->relationship('product', 'attribute_data->name->value->en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->translateAttribute('name'))
                    ->searchable()
                    ->preload()
                    ->label('Товар'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductShortPoints::route('/'),
            'create' => Pages\CreateProductShortPoint::route('/create'),
            'edit' => Pages\EditProductShortPoint::route('/{record}/edit'),
        ];
    }
}
