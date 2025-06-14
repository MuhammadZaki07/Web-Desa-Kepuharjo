<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Galeri';
    protected static ?string $navigationGroup = 'Profil & Identitas Desa';
    protected static ?int $navigationSort = 3;
    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $count = static::getModel()::count();
        return $count > 50 ? 'success' : ($count > 20 ? 'warning' : 'primary');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Galeri')
                    ->description('Kelola informasi dasar galeri Anda')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul Galeri')
                                    ->placeholder('Masukkan judul galeri...')
                                    ->maxLength(255)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) =>
                                        $set('slug', \Illuminate\Support\Str::slug($state))
                                    ),

                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->placeholder('auto-generated')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(ignoreRecord: true),
                            ]),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->placeholder('Tulis deskripsi singkat tentang galeri ini...')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Grid::make(3)
                            ->schema([
                                Select::make('type')
                                    ->label('Kategori Galeri')
                                    ->options([
                                        'pkk' => 'PKK',
                                        'karang_taruna' => 'Karang Taruna',
                                        'gallery' => 'Galeri Umum',
                                        'kegiatan' => 'Kegiatan Desa',
                                        'infrastruktur' => 'Infrastruktur',
                                        'wisata' => 'Wisata Desa',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->searchable()
                                    ->preload()
                                    ->default('gallery')
                                    ->helperText('Pilih kategori yang sesuai dengan konten galeri'),

                                DatePicker::make('event_date')
                                    ->label('Tanggal Acara')
                                    ->placeholder('Pilih tanggal acara')
                                    ->displayFormat('d/m/Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->helperText('Opsional: tanggal saat foto diambil'),

                                Toggle::make('is_featured')
                                    ->label('Tampilkan di Beranda')
                                    ->helperText('Galeri akan muncul di halaman utama')
                                    ->default(false)
                                    ->inline(false),
                            ]),
                    ]),

                Section::make('Media Galeri')
                    ->description('Upload dan kelola gambar galeri')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        FileUpload::make('path')
                            ->label('Upload Gambar')
                            ->image()
                            ->multiple()
                            ->required()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->directory('galeri')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '3:2',
                                '1:1',
                            ])
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->helperText('
                                • Maksimal 2MB per gambar
                                • Format: JPEG, PNG, WebP
                                • Resolusi minimal: 800x600px
                                • Gunakan gambar berkualitas tinggi untuk hasil terbaik
                            ')
                            ->hint('Drag & drop atau klik untuk upload')
                            ->hintIcon('heroicon-o-cloud-arrow-up')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Preview')
                    ->height(80)
                    ->width(80)
                    ->extraAttributes(['class' => 'rounded-lg'])
                    ->defaultImageUrl(url('/images/placeholder.jpg')),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->color('primary')
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 30 ? $state : null;
                    }),

                BadgeColumn::make('type')
                    ->label('Kategori')
                    ->formatStateUsing(fn($state) => match($state) {
                        'pkk' => 'PKK',
                        'karang_taruna' => 'Karang Taruna',
                        'gallery' => 'Galeri Umum',
                        'kegiatan' => 'Kegiatan Desa',
                        'infrastruktur' => 'Infrastruktur',
                        'wisata' => 'Wisata Desa',
                        default => ucfirst($state)
                    })
                    ->colors([
                        'primary' => 'gallery',
                        'success' => 'pkk',
                        'warning' => 'karang_taruna',
                        'info' => 'kegiatan',
                        'secondary' => 'infrastruktur',
                        'danger' => 'wisata',
                    ])
                    ->icons([
                        'heroicon-o-photo' => 'gallery',
                        'heroicon-o-users' => 'pkk',
                        'heroicon-o-user-group' => 'karang_taruna',
                        'heroicon-o-calendar-days' => 'kegiatan',
                        'heroicon-o-building-office' => 'infrastruktur',
                        'heroicon-o-map-pin' => 'wisata',
                    ]),

                ToggleColumn::make('is_featured')
                    ->label('Unggulan')
                    ->onIcon('heroicon-o-star')
                    ->offIcon('heroicon-o-star')
                    ->onColor('warning')
                    ->offColor('gray'),

                TextColumn::make('event_date')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('Tidak ada')
                    ->icon('heroicon-o-calendar-days'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->since()
                    ->icon('heroicon-o-clock'),

                TextColumn::make('path')
                    ->label('Jumlah Foto')
                    ->formatStateUsing(fn($state) => is_array($state) ? count($state) . ' foto' : '1 foto')
                    ->badge()
                    ->color('success'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Kategori')
                    ->options([
                        'pkk' => 'PKK',
                        'karang_taruna' => 'Karang Taruna',
                        'gallery' => 'Galeri Umum',
                        'kegiatan' => 'Kegiatan Desa',
                        'infrastruktur' => 'Infrastruktur',
                        'wisata' => 'Wisata Desa',
                    ])
                    ->multiple()
                    ->native(false),

                Filter::make('is_featured')
                    ->label('Galeri Unggulan')
                    ->query(fn(Builder $query) => $query->where('is_featured', true))
                    ->toggle(),

                Filter::make('today')
                    ->label('Hari Ini')
                    ->query(fn(Builder $query) => $query->whereDate('created_at', now()->toDateString()))
                    ->indicator('Hari Ini'),

                Filter::make('this_week')
                    ->label('Minggu Ini')
                    ->query(
                        fn(Builder $query) =>
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    )
                    ->indicator('Minggu Ini'),

                Filter::make('this_month')
                    ->label('Bulan Ini')
                    ->query(
                        fn(Builder $query) =>
                        $query->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                    )
                    ->indicator('Bulan Ini'),

                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')
                            ->label('Dari Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('until')
                            ->label('Sampai Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('created_at', '<=', $data['until']));
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['from'])->format('d/m/Y');
                        }
                        if ($data['until'] ?? null) {
                            $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['until'])->format('d/m/Y');
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),
                DeleteAction::make()
                    ->label('Hapus')
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\BulkAction::make('mark_featured')
                        ->label('Tandai Unggulan')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->action(fn($records) => $records->each->update(['is_featured' => true]))
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('unmark_featured')
                        ->label('Hapus dari Unggulan')
                        ->icon('heroicon-o-star')
                        ->color('gray')
                        ->action(fn($records) => $records->each->update(['is_featured' => false]))
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Galeri Pertama')
                    ->icon('heroicon-o-plus'),
            ])
            ->emptyStateHeading('Belum ada galeri')
            ->emptyStateDescription('Mulai dengan membuat galeri pertama Anda untuk menampilkan foto-foto kegiatan desa.')
            ->emptyStateIcon('heroicon-o-photo')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'type'];
    }

    public static function getGlobalSearchResultTitle(\Illuminate\Database\Eloquent\Model $record): string
    {
        return $record->title ?? 'Galeri #' . $record->id;
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Kategori' => ucfirst($record->type),
            'Dibuat' => $record->created_at->format('d M Y'),
        ];
    }
}
