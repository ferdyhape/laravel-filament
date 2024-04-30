<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make('Product Information')->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->placeholder('Product Name'),
                    Textarea::make('description')
                        ->label('Description')
                        ->required()
                        ->placeholder('Product Description'),
                    TextInput::make('price')
                        ->label('Price')
                        ->required()
                        ->placeholder('Product Price'),
                    Select::make('category_id')
                        ->label('Category')
                        ->required()
                        ->options(
                            Category::all()->pluck('name', 'id')->toArray()
                        ),
                    SpatieMediaLibraryFileUpload::make('image')
                        ->label('Image')
                        ->required()
                        ->placeholder('Product Image')
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('price')->money('IDR')
                    ->label('Price')->searchable(),
                TextColumn::make('description')->label('Description')->searchable()->limit(20),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('image')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label('')->requiresConfirmation(),
            ])->actionsColumnLabel('Actions')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
