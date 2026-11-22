<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Shop Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required(),

            Forms\Components\Select::make('category')
                ->options([
                    'men' => 'Men',
                    'female' => 'Female',
                    'footwear' => 'Footwear',
                    'watches' => 'Watches',
                ])
                ->required(),

            Forms\Components\TextInput::make('price')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('discount_price')
                ->numeric()
                ->nullable(),

            Forms\Components\Textarea::make('description')
                ->required(),

            // ✅ Repeater for multiple images
        Repeater::make('images')
    ->relationship()
    ->schema([
        FileUpload::make('image')
            ->label('Product Image')
            ->image()
            ->directory('products')
            ->getUploadedFileNameForStorageUsing(
                fn (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file) => $file->hashName()
            ),
    ])
    ->columns(1)
    ->createItemButtonLabel('Add Image')
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category')->sortable(),
            Tables\Columns\TextColumn::make('price')->sortable(),
            Tables\Columns\TextColumn::make('discount_price')->sortable(),

            // Show first product image in table
            Tables\Columns\ImageColumn::make('images.image')
                ->label('Image')
                ->getStateUsing(fn ($record) => $record->images->first()?->image),

            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
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
