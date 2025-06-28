<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;
use Illuminate\Validation\Rule;
use Filament\Notifications\Notification;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $modelLabel = 'Category';
    protected static ?string $navigationGroup = "Konten";

    protected static ?string $pluralModelLabel = 'Categories';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Category Information')
                    ->description('Create and manage categories for different content types')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $context, $state, Forms\Set $set) {
                                        if ($context === 'create') {
                                            $set('slug', \Illuminate\Support\Str::slug($state));
                                        }
                                    })
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->rules(function (callable $get, ?Category $record) {
                                        return [
                                            'alpha_dash',
                                            Rule::unique('categories', 'slug')
                                                ->where(fn($query) => $query->where('type', $get('type')))
                                                ->ignore($record),
                                        ];
                                    })
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('Content Type')
                                    ->required()
                                    ->options([
                                        'blogs' => 'Blogs',
                                        'umkm' => 'UMKM',
                                        'wisata' => 'Wisata',
                                    ])
                                    ->native(false)
                                    ->helperText('Select the content type this category belongs to')
                                    ->columnSpan(1),

                                Forms\Components\ColorPicker::make('color')
                                    ->label('Color')
                                    ->default('#3B82F6')
                                    ->helperText('Color used for visual identification')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),

                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'blogs',
                        'success' => 'umkm',
                        'warning' => 'wisata',
                    ])
                    ->icons([
                        'heroicon-o-document-text' => 'blogs',
                        'heroicon-o-building-storefront' => 'umkm',
                        'heroicon-o-map-pin' => 'wisata',
                    ]),

                Tables\Columns\ColorColumn::make('color')
                    ->label('Color'),

                Tables\Columns\TextColumn::make('articles_count')
                    ->counts('articles')
                    ->label('Articles')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('umkm_products_count')
                    ->counts('umkmProducts')
                    ->label('Umkm')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('wisata_count')
                    ->counts('wisata')
                    ->label('Wisata')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'blogs' => 'Blogs',
                        'umkm' => 'UMKM',
                        'wisata' => 'Wisata',
                    ])
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Category')
                    ->modalDescription('Are you sure you want to delete this category? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, delete it')
                    ->before(function (Category $record) {
                        if ($record->articles()->exists()) {
                            Notification::make()
                                ->title('Cannot Delete Category')
                                ->body('This category is being used by articles and cannot be deleted.')
                                ->danger()
                                ->send();

                            return false;
                        }

                        if ($record->umkmProducts()->exists()) {
                            Notification::make()
                                ->title('Cannot Delete Category')
                                ->body('This category is being used by UMKM products and cannot be deleted.')
                                ->danger()
                                ->send();

                            return false;
                        }

                        if ($record->wisata()->exists()) {
                            Notification::make()
                                ->title('Cannot Delete Category')
                                ->body('This category is being used by tourism data and cannot be deleted.')
                                ->danger()
                                ->send();

                            return false;
                        }
                    })
                    ->visible(fn (Category $record) => self::canDeleteCategory($record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->articles()->exists() ||
                                    $record->umkmProducts()->exists() ||
                                    $record->wisata()->exists()) {

                                    Notification::make()
                                        ->title('Cannot Delete Categories')
                                        ->body("Category '{$record->name}' is being used and cannot be deleted. Please remove all related content first.")
                                        ->danger()
                                        ->send();

                                    return false;
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No categories found')
            ->emptyStateDescription('Create your first category to organize your content.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create Category')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function canDeleteCategory(Category $record): bool
    {
        return $record->articles()->count() === 0 &&
            $record->umkmProducts()->count() === 0 &&
            $record->wisata()->count() === 0;
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
