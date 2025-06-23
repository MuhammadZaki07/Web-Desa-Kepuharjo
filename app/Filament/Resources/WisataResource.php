<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WisataResource\Pages;
use App\Models\Category;
use App\Models\Wisata;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class WisataResource extends Resource
{
    protected static ?string $model = Wisata::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Wisata';

    protected static ?string $pluralModelLabel = 'Wisata';

    protected static ?string $modelLabel = 'Wisata';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Sektor Ekonomi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Wisata')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn(string $context, $state, Forms\Set $set) =>
                                        $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                                    ),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Wisata::class, 'slug', ignoreRecord: true)
                                    ->rules(['alpha_dash'])
                                    ->readOnly()
                                    ->helperText('URL-friendly version dari nama wisata'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Kategori')
                                    ->relationship(
                                        name: 'category',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn($query) => $query->where('type', 'wisata')
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
                                                fn(string $context, $state, Forms\Set $set) =>
                                                $context === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                                            ),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(Category::class, 'slug')
                                            ->rules(['alpha_dash']),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi')
                                            ->maxLength(500),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Status Aktif')
                                            ->default(true),
                                        Forms\Components\Hidden::make('type')
                                            ->default('wisata'),
                                    ])
                                    ->createOptionUsing(function (array $data): int {
                                        return Category::create($data)->getKey();
                                    })
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name),

                                Forms\Components\TextInput::make('location')
                                    ->label('Lokasi')
                                    ->required()
                                    ->placeholder('Kepuharjo , Kab.Malang')
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->required()
                            ->maxLength(500)
                            ->rows(3),

                        Forms\Components\RichEditor::make('long_description')
                            ->label('Deskripsi Lengkap')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Lokasi & Koordinat')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Alamat Lengkap')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->numeric()
                                    ->step('any')
                                    ->placeholder('-7.966620')
                                    ->helperText('Contoh: -7.966620'),

                                Forms\Components\TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->numeric()
                                    ->step('any')
                                    ->placeholder('112.632632')
                                    ->helperText('Contoh: 112.632632'),
                            ]),
                    ]),

                Forms\Components\Section::make('Harga & Biaya')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price')
                                    ->label('Harga Tiket Dewasa')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rp')
                                    ->helperText('Isi 0 jika gratis'),

                                Forms\Components\TextInput::make('child_price')
                                    ->label('Harga Tiket Anak')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->helperText('Kosongkan jika sama dengan dewasa'),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('parking_motor_price')
                                    ->label('Tarif Parkir Motor')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rp'),

                                Forms\Components\TextInput::make('parking_car_price')
                                    ->label('Tarif Parkir Mobil')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rp'),
                            ]),
                    ]),

                Forms\Components\Section::make('Jam Operasional')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TimePicker::make('opening_time')
                                    ->label('Jam Buka')
                                    ->seconds(false),

                                Forms\Components\TimePicker::make('closing_time')
                                    ->label('Jam Tutup')
                                    ->seconds(false),
                            ]),
                    ]),

                Forms\Components\Section::make('Gambar & Media')
                    ->schema([
                        Forms\Components\FileUpload::make('main_image')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('wisata/main')
                            ->disk('public')
                            ->maxSize(1020)
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText('Ukuran maksimal 1MB. Rasio yang disarankan 16:9'),

                        Forms\Components\FileUpload::make('gallery_images')
                            ->label('Galeri Gambar')
                            ->image()
                            ->multiple()
                            ->imageEditor()
                            ->directory('wisata/gallery')
                            ->disk('public')
                            ->reorderable()
                            ->maxFiles(10)
                           ->maxSize(1020)
                            ->helperText('Maksimal 10 gambar, masing-masing 1MB'),
                    ]),

                Forms\Components\Section::make('Kontak & Media Sosial')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('whatsapp')
                                    ->label('WhatsApp')
                                    ->tel()
                                    ->maxLength(20)
                                    ->placeholder('628123456789')
                                    ->helperText('Format: 628123456789 (tanpa +)'),
                            ]),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),

                        Forms\Components\KeyValue::make('social_media')
                            ->label('Media Sosial')
                            ->keyLabel('Platform')
                            ->valueLabel('URL/Username')
                            ->addActionLabel('Tambah Media Sosial')
                            ->helperText('Contoh: instagram -> @wisata_malang'),
                    ]),

                Forms\Components\Section::make('Fasilitas & Aktivitas')
                    ->schema([
                        Forms\Components\TagsInput::make('facilities')
                            ->label('Fasilitas')
                            ->placeholder('Ketik fasilitas dan tekan Enter')
                            ->helperText('Contoh: Toilet, Mushola, Parkir, Kantin'),

                        Forms\Components\TagsInput::make('activities')
                            ->label('Aktivitas')
                            ->placeholder('Ketik aktivitas dan tekan Enter')
                            ->helperText('Contoh: Berenang, Hiking, Fotografi, Camping'),
                    ]),

                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true)
                                    ->helperText('Wisata akan tampil di website jika aktif'),

                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Wisata Unggulan')
                                    ->default(false)
                                    ->helperText('Wisata akan tampil di halaman depan'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('main_image')
                    ->label('Gambar')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500&h=300&fit=crop'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Wisata')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn(Wisata $record): string => $record->location),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(
                        fn(string $state): string =>
                        $state == 0 ? 'Gratis' : 'Rp ' . number_format($state, 0, ',', '.')
                    )
                    ->sortable()
                    ->color(fn(string $state): string => $state == 0 ? 'success' : 'primary'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('views')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->placeholder('Semua Kategori'),

                Tables\Filters\Filter::make('is_featured')
                    ->label('Wisata Unggulan')
                    ->query(fn(Builder $query): Builder => $query->where('is_featured', true))
                    ->toggle(),

                Tables\Filters\Filter::make('is_active')
                    ->label('Status Aktif')
                    ->query(fn(Builder $query): Builder => $query->where('is_active', true))
                    ->toggle(),

                Tables\Filters\Filter::make('price')
                    ->form([
                        Forms\Components\Select::make('price_range')
                            ->label('Range Harga')
                            ->options([
                                'free' => 'Gratis',
                                '0-25000' => 'Rp 0 - 25.000',
                                '25000-50000' => 'Rp 25.000 - 50.000',
                                '50000-100000' => 'Rp 50.000 - 100.000',
                                '100000+' => 'Rp 100.000+',
                            ])
                            ->placeholder('Pilih Range Harga'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['price_range'],
                            function (Builder $query, $range) {
                                return match ($range) {
                                    'free' => $query->where('price', 0),
                                    '0-25000' => $query->whereBetween('price', [0, 25000]),
                                    '25000-50000' => $query->whereBetween('price', [25000, 50000]),
                                    '50000-100000' => $query->whereBetween('price', [50000, 100000]),
                                    '100000+' => $query->where('price', '>', 100000),
                                    default => $query,
                                };
                            }
                        );
                    }),
            ])
            ->actions([
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
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn($records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('feature')
                        ->label('Jadikan Unggulan')
                        ->icon('heroicon-o-star')
                        ->color('amber')
                        ->action(fn($records) => $records->each->update(['is_featured' => true]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Wisata')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nama Wisata')
                                    ->size('lg')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('category.name')
                                    ->label('Kategori')
                                    ->badge()
                                    ->color('info'),
                            ]),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('long_description')
                            ->label('Deskripsi Lengkap')
                            ->html()
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Lokasi & Kontak')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('location')
                                    ->label('Lokasi'),

                                Infolists\Components\TextEntry::make('address')
                                    ->label('Alamat'),
                            ]),

                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('phone')
                                    ->label('Telepon')
                                    ->icon('heroicon-o-phone'),

                                Infolists\Components\TextEntry::make('whatsapp')
                                    ->label('WhatsApp')
                                    ->icon('heroicon-o-chat-bubble-left-right'),

                                Infolists\Components\TextEntry::make('email')
                                    ->label('Email')
                                    ->icon('heroicon-o-envelope'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Harga & Operasional')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('formatted_price')
                                    ->label('Harga Tiket Dewasa'),

                                Infolists\Components\TextEntry::make('formatted_child_price')
                                    ->label('Harga Tiket Anak')
                                    ->placeholder('Sama dengan dewasa'),
                            ]),

                        Infolists\Components\TextEntry::make('operating_hours')
                            ->label('Jam Operasional')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Gambar')
                    ->schema([
                        Infolists\Components\ImageEntry::make('main_image')
                            ->label('Gambar Utama')
                            ->size(300),

                        Infolists\Components\RepeatableEntry::make('gallery_images')
                            ->label('Galeri')
                            ->schema([
                                Infolists\Components\ImageEntry::make('')
                                    ->hiddenLabel()
                                    ->size(150),
                            ])
                            ->columns(4),
                    ]),

                Infolists\Components\Section::make('Fasilitas & Aktivitas')
                    ->schema([
                        Infolists\Components\TextEntry::make('facilities')
                            ->label('Fasilitas')
                            ->badge()
                            ->separator(','),

                        Infolists\Components\TextEntry::make('activities')
                            ->label('Aktivitas')
                            ->badge()
                            ->separator(','),
                    ]),

                Infolists\Components\Section::make('Statistik')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('views')
                                    ->label('Total Views')
                                    ->numeric()
                                    ->badge()
                                    ->color('gray'),

                                Infolists\Components\IconEntry::make('is_featured')
                                    ->label('Wisata Unggulan')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-star')
                                    ->trueColor('amber'),

                                Infolists\Components\IconEntry::make('is_active')
                                    ->label('Status')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-check-circle')
                                    ->falseIcon('heroicon-o-x-circle')
                                    ->trueColor('success')
                                    ->falseColor('danger'),
                            ]),
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
            'index' => Pages\ListWisatas::route('/'),
            'create' => Pages\CreateWisata::route('/create'),
            'view' => Pages\ViewWisata::route('/{record}'),
            'edit' => Pages\EditWisata::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category']);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()
            ->with(['category']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location', 'description', 'category.name'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Kategori' => $record->category?->name,
            'Lokasi' => $record->location,
        ];
    }
    
       public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
