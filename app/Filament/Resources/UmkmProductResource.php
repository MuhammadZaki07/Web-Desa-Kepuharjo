<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UmkmProductResource\Pages;
use App\Models\Category;
use App\Models\UmkmProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Str;

class UmkmProductResource extends Resource
{
    protected static ?string $model = UmkmProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Produk UMKM';

    protected static ?string $modelLabel = 'Produk UMKM';

    protected static ?string $pluralModelLabel = 'Produk UMKM';

    protected static ?string $navigationGroup = 'Sektor Ekonomi';

    protected static ?int $navigationSort = -1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Produk')
                            ->description('Informasi dasar produk UMKM')
                            ->icon('heroicon-m-shopping-bag')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Nama Produk')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn(string $operation, $state, Forms\Set $set) =>
                                        $operation === 'create' ? $set('slug', Str::slug($state)) : null
                                    ),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(UmkmProduct::class, 'slug', ignoreRecord: true)
                                    ->disabled()
                                    ->dehydrated(),

                                Forms\Components\Textarea::make('description')
                                    ->label('Deskripsi Singkat')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),

                                Forms\Components\RichEditor::make('detailed_description')
                                    ->label('Deskripsi Detail')
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'bulletList',
                                        'orderedList',
                                        'h2',
                                        'h3',
                                    ]),
                            ])->columns(2),

                        Forms\Components\Section::make('Kategori & Harga')
                            ->description('Kategori dan informasi harga produk')
                            ->icon('heroicon-m-tag')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship(
                                        'category',
                                        'name',
                                        fn(Builder $query) =>
                                        $query->where('type', 'umkm')
                                    )
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nama Kategori')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(
                                                fn(string $state, Forms\Set $set) =>
                                                $set('slug', Str::slug($state))
                                            ),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(Category::class, 'slug')
                                            ->disabled()
                                            ->dehydrated(),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi')
                                            ->rows(3),

                                        Forms\Components\ColorPicker::make('color')
                                            ->label('Warna')
                                            ->default('#3B82F6'),

                                        Forms\Components\Hidden::make('type')
                                            ->default('umkm'),
                                    ])
                                    ->createOptionModalHeading('Tambah Kategori Baru'),

                                Forms\Components\TextInput::make('price')
                                    ->label('Harga')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->step(1000)
                                    ->minValue(0),
                            ])->columns(2),

                        Forms\Components\Section::make('Kontak & Lokasi')
                            ->description('Informasi kontak dan lokasi penjual')
                            ->icon('heroicon-m-map-pin')
                            ->schema([
                                Forms\Components\TextInput::make('location')
                                    ->label('Lokasi')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Desa, Kecamatan, Kabupaten'),

                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label('Nomor WhatsApp')
                                    ->required()
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('08xxxxxxxxxx'),
                            ])->columns(2),

                        Forms\Components\Section::make('Informasi Tambahan')
                            ->description('Detail tambahan produk')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                Forms\Components\Repeater::make('product_info')
                                    ->label('Informasi Produk')
                                    ->schema([
                                        Forms\Components\TextInput::make('label')
                                            ->label('Label')
                                            ->placeholder('Berat bersih, Masa simpan, dll'),
                                        Forms\Components\TextInput::make('value')
                                            ->label('Nilai')
                                            ->placeholder('1 kg, 12 bulan, dll'),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Tambah Informasi')
                                    ->defaultItems(0)
                                    ->columnSpanFull(),

                                Forms\Components\Repeater::make('suitable_for')
                                    ->label('Cocok Untuk')
                                    ->schema([
                                        Forms\Components\TextInput::make('description')
                                            ->label('Deskripsi')
                                            ->placeholder('Keluarga sehat, Restoran, dll'),
                                    ])
                                    ->simple(
                                        Forms\Components\TextInput::make('description')
                                            ->placeholder('Keluarga sehat, Restoran, dll')
                                    )
                                    ->addActionLabel('Tambah Item')
                                    ->defaultItems(0)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Gambar Produk')
                            ->description('Upload gambar produk (maks 5 gambar)')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Forms\Components\FileUpload::make('images')
                                    ->label('Gambar')
                                    ->image()
                                    ->multiple()
                                    ->imageEditor()
                                    ->maxFiles(5)
                                    ->reorderable()
                                    ->directory('umkm-products/' . now()->year)
                                    ->maxSize(1020)
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1024')
                                    ->imageResizeTargetHeight('576')
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Section::make('Status')
                            ->description('Status publikasi produk')
                            ->icon('heroicon-m-eye')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true)
                                    ->helperText('Produk akan ditampilkan di website jika aktif'),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Gambar')
                    ->circular()
                    ->stacked()
                    ->limit(1)
                    ->limitedRemainingText()
                    ->getStateUsing(fn($record) => $record->images[0] ?? null),

                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->limit(30),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Minuman' => 'gray',
                        'Makanan' => 'warning',
                        default => 'secondary'
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship(
                        'category',
                        'name',
                        fn(Builder $query) =>
                        $query->where('type', 'umkm')
                    )
                    ->indicator('Kategori'),

                Filter::make('is_active')
                    ->label('Status Aktif')
                    ->query(fn(Builder $query): Builder => $query->where('is_active', true))
                    ->indicator('Aktif'),

                Filter::make('price_range')
                    ->form([
                        Forms\Components\TextInput::make('price_from')
                            ->label('Harga Dari')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('price_to')
                            ->label('Harga Sampai')
                            ->numeric()
                            ->prefix('Rp'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['price_from'],
                                fn(Builder $query, $price): Builder => $query->where('price', '>=', $price),
                            )
                            ->when(
                                $data['price_to'],
                                fn(Builder $query, $price): Builder => $query->where('price', '<=', $price),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['price_from'] ?? null) {
                            $indicators[] = 'Harga dari: Rp ' . number_format($data['price_from']);
                        }
                        if ($data['price_to'] ?? null) {
                            $indicators[] = 'Harga sampai: Rp ' . number_format($data['price_to']);
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn($records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-shopping-bag')
            ->emptyStateHeading('Belum ada produk UMKM')
            ->emptyStateDescription('Mulai tambahkan produk UMKM pertama Anda.')
            ->striped();
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Produk')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Nama Produk')
                            ->weight(FontWeight::Bold)
                            ->size('lg'),

                        TextEntry::make('category.name')
                            ->label('Kategori')
                            ->badge()
                            ->color(fn($record) => $record->category?->color ?? 'gray'),

                        TextEntry::make('price')
                            ->label('Harga')
                            ->money('IDR')
                            ->weight(FontWeight::SemiBold)
                            ->color('success'),

                        TextEntry::make('location')
                            ->label('Lokasi')
                            ->icon('heroicon-m-map-pin'),

                        TextEntry::make('whatsapp_number')
                            ->label('WhatsApp')
                            ->icon('heroicon-m-phone'),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Galeri Produk')
                    ->schema([
                        ImageEntry::make('images')
                            ->label('')
                            ->columnSpanFull()
                            ->hiddenLabel()
                            ->size('lg'),
                    ])
                    ->visible(fn($record) => !empty($record->images)),

                Section::make('Deskripsi Detail')
                    ->schema([
                        TextEntry::make('detailed_description')
                            ->label('')
                            ->html()
                            ->hiddenLabel()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn($record) => !empty($record->detailed_description)),

                Section::make('Informasi Tambahan')
                    ->schema([
                        TextEntry::make('product_info')
                            ->label('Informasi Produk')
                            ->listWithLineBreaks()
                            ->formatStateUsing(function ($state) {
                                return ($state['label'] ?? 'N/A') . ': ' . ($state['value'] ?? 'N/A');
                            }),

                        TextEntry::make('suitable_for')
                            ->label('Cocok Untuk')
                            ->listWithLineBreaks()
                            ->formatStateUsing(function ($state) {
                                return is_array($state)
                                    ? collect($state)->implode("\n")
                                    : $state;
                            }),

                    ])
                    ->columns(2)
                    ->visible(fn($record): bool => !empty($record->product_info) || !empty($record->suitable_for)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUmkmProducts::route('/'),
            'create' => Pages\CreateUmkmProduct::route('/create'),
            'view' => Pages\ViewUmkmProduct::route('/{record}'),
            'edit' => Pages\EditUmkmProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'location', 'category.name'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Kategori' => $record->category?->name,
            'Harga' => $record->formatted_price,
            'Lokasi' => $record->location,
        ];
    }
}
