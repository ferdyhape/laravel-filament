<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
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
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add Product For This Category'),
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
}
