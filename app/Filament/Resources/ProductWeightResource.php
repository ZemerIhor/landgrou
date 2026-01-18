<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductWeightResource\Pages;
use App\Filament\Resources\ProductWeightResource\RelationManagers;
use App\Models\ProductWeight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductWeightResource extends Resource
{
    protected static ?string $model = ProductWeight::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    
    protected static ?string $navigationGroup = 'Каталог';
    
    protected static ?string $navigationLabel = 'Ваги товарів';
    
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
                Forms\Components\Tabs::make('Переклади')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('EN')
                            ->schema([
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Назва (EN)')
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('PL')
                            ->schema([
                                Forms\Components\TextInput::make('name.pl')
                                    ->label('Назва (PL)')
                                    ->required(),
                            ]),
                    ])->columnSpanFull(),
                    
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255)
                    ->helperText('Приклади: 10, 20, 25, насипом'),
                    
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
                    
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
                    
                Forms\Components\Section::make('Товари')
                    ->description('Оберіть товари для цієї ваги')
                    ->schema([
                        Forms\Components\Select::make('product_ids')
                            ->label('Товари')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(function () {
                                return \Lunar\Models\Product::all()->mapWithKeys(function ($product) {
                                    $name = $product->translateAttribute('name') ?? 'Товар #' . $product->id;
                                    return [$product->id => $name];
                                });
                            })
                            ->default(function ($record) {
                                if (!$record) return [];
                                return \Lunar\Models\Product::where('product_weight_id', $record->id)->pluck('id')->toArray();
                            }),
                    ])
                    ->columnSpanFull()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name.en')
                    ->label('Назва (EN)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name.pl')
                    ->label('Назва (PL)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Товари'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активний')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductWeights::route('/'),
            'create' => Pages\CreateProductWeight::route('/create'),
            'edit' => Pages\EditProductWeight::route('/{record}/edit'),
        ];
    }
}
