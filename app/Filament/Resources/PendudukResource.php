<?php

namespace App\Filament\Resources;

use App\Filament\Exports\PendudukExporter;
use App\Filament\Imports\PendudukImporter;
use App\Filament\Resources\PendudukResource\Pages;
use App\Models\Penduduk;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Exports\ExportColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data Penduduk';

    protected static ?string $modelLabel = 'Penduduk';

    protected static ?string $navigationGroup = "User Management";

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['super_admin']);
    }

    public static function canAccess(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['super_admin']);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('user', function (Builder $query) {
                $query->where('role', 'penduduk');
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Akun')
                    ->description('Data akun pengguna untuk login sistem')
                    ->icon('heroicon-o-user-circle')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('user.photo')
                                    ->label('Foto Profil')
                                    ->image()
                                    ->avatar()
                                    ->imageEditor()
                                    ->circleCropper()
                                    ->directory('profile-photos')
                                    ->visibility('private')
                                    ->columnSpanFull(),

                                TextInput::make('user.name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                        if ($operation !== 'create') {
                                            return;
                                        }
                                        $set('user.email', strtolower(str_replace(' ', '.', $state)) . '@example.com');
                                    }),

                                TextInput::make('user.phone')
                                    ->label('No. Telepon')
                                    ->tel()
                                    ->required()
                                    ->maxLength(20)
                                    ->placeholder('08123456789')
                                    ->rules([
                                        function ($livewire) {
                                            return function (string $attribute, $value, Closure $fail) use ($livewire) {
                                                $currentUserId = null;
                                                if (method_exists($livewire, 'getRecord') && $livewire->getRecord()) {
                                                    $currentUserId = $livewire->getRecord()->user?->id;
                                                }

                                                $existingUser = User::where('phone', $value)
                                                    ->when($currentUserId, function ($query) use ($currentUserId) {
                                                        $query->where('id', '!=', $currentUserId);
                                                    })
                                                    ->first();

                                                if ($existingUser) {
                                                    $fail('Nomor telepon sudah digunakan.');
                                                }
                                            };
                                        },
                                    ]),
                            ]),
                    ]),

                Section::make('Data Pribadi')
                    ->description('Informasi pribadi dan identitas penduduk')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('nik')
                                    ->label('NIK')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->length(16)
                                    ->numeric()
                                    ->placeholder('1234567890123456')
                                    ->columnSpan(2),

                                Select::make('jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->required()
                                    ->options([
                                        'L' => 'Laki-laki',
                                        'P' => 'Perempuan',
                                    ])
                                    ->native(false),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->maxLength(255)
                                    ->required()
                                    ->placeholder('Jakarta'),

                                DatePicker::make('tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->native(false)
                                    ->required()
                                    ->displayFormat('d/m/Y')
                                    ->maxDate(now()),
                            ]),
                    ]),

                Section::make('Informasi Tempat Tinggal')
                    ->description('Alamat dan informasi domisili')
                    ->icon('heroicon-o-home')
                    ->schema([
                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->required()
                            ->placeholder('Jl. Contoh No. 123, Kelurahan ABC, Kecamatan XYZ')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('RT')
                                    ->label('RT')
                                    ->numeric()
                                    ->required()
                                    ->maxLength(3)
                                    ->placeholder('001'),

                                TextInput::make('RW')
                                    ->label('RW')
                                    ->numeric()
                                    ->required()
                                    ->maxLength(3)
                                    ->placeholder('001'),
                            ]),
                    ]),

                Section::make('Informasi Tambahan')
                    ->description('Data demografis dan sosial')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('agama')
                                    ->label('Agama')
                                    ->required()
                                    ->options([
                                        'Islam' => 'Islam',
                                        'Kristen' => 'Kristen',
                                        'Katolik' => 'Katolik',
                                        'Hindu' => 'Hindu',
                                        'Buddha' => 'Buddha',
                                        'Konghucu' => 'Konghucu',
                                    ])
                                    ->native(false),

                                Select::make('status_perkawinan')
                                    ->label('Status Perkawinan')
                                    ->required()
                                    ->options([
                                        'Belum Kawin' => 'Belum Kawin',
                                        'Kawin' => 'Kawin',
                                        'Cerai Hidup' => 'Cerai Hidup',
                                        'Cerai Mati' => 'Cerai Mati',
                                    ])
                                    ->native(false),

                                TextInput::make('pekerjaan')
                                    ->label('Pekerjaan')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Pegawai Swasta'),

                                Select::make('pendidikan')
                                    ->label('Pendidikan Terakhir')
                                    ->required()
                                    ->options([
                                        'Tidak Sekolah' => 'Tidak Sekolah',
                                        'SD' => 'SD',
                                        'SMP' => 'SMP',
                                        'SMA' => 'SMA',
                                        'D1' => 'D1',
                                        'D2' => 'D2',
                                        'D3' => 'D3',
                                        'S1' => 'S1',
                                        'S2' => 'S2',
                                        'S3' => 'S3',
                                    ])
                                    ->native(false),
                            ]),

                        Textarea::make('catatan_penduduk')
                            ->label('Catatan')
                            ->rows(3)
                            ->placeholder('Catatan khusus tentang penduduk ini...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->filters(static::getTableFilters())
            ->headerActions([
                ImportAction::make()
                    ->importer(PendudukImporter::class)
                    ->visible(fn() => in_array(Auth::user()->role, ['super_admin','admin'])),

                ExportAction::make()
                    ->exporter(PendudukExporter::class)
                    ->visible(fn() => in_array(Auth::user()->role, ['super_admin','admin'])),
            ])
            ->emptyStateHeading('Belum ada data penduduk')
            ->emptyStateDescription('Mulai dengan menambahkan data penduduk pertama.')
            ->emptyStateIcon('heroicon-o-user-group')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Penduduk')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function getTableColumns(): array
    {
        return [
            ImageColumn::make('user.photo')
                ->label('Foto')
                ->circular()
                ->size(50)
                ->defaultImageUrl(fn($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->user->name ?? 'Unknown') . '&color=7F9CF5&background=EBF4FF'),

            TextColumn::make('user.name')
                ->label('Nama Lengkap')
                ->searchable()
                ->sortable()
                ->weight('bold')
                ->size('sm')
                ->description(fn($record) => $record->nik),

            TextColumn::make('jenis_kelamin')
                ->label('L/P')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'L' => 'blue',
                    'P' => 'pink',
                    default => 'gray',
                })
                ->icon(fn(string $state): string => match ($state) {
                    'L' => 'heroicon-o-user',
                    'P' => 'heroicon-o-user',
                    default => 'heroicon-o-question-mark-circle',
                }),

            TextColumn::make('age')
                ->label('Umur')
                ->state(function ($record) {
                    if ($record->tanggal_lahir) {
                        return Carbon::parse($record->tanggal_lahir)->age . ' tahun';
                    }
                    return '-';
                })
                ->sortable(),

            TextColumn::make('alamat')
                ->label('Alamat')
                ->limit(30)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
                    if (strlen($state) <= 30) {
                        return null;
                    }
                    return $state;
                })
                ->icon('heroicon-o-map-pin')
                ->color('gray'),

            TextColumn::make('rt_rw')
                ->label('RT/RW')
                ->state(function ($record) {
                    $rt = str_pad($record->RT ?? '0', 3, '0', STR_PAD_LEFT);
                    $rw = str_pad($record->RW ?? '0', 3, '0', STR_PAD_LEFT);
                    return "{$rt}/{$rw}";
                })
                ->badge()
                ->color('info'),

            TextColumn::make('user.phone')
                ->label('Telepon')
                ->copyable()
                ->icon('heroicon-o-phone')
                ->iconColor('green')
                ->size('sm')
                ->toggleable(true),

            TextColumn::make('pekerjaan')
                ->label('Pekerjaan')
                ->searchable()
                ->toggleable(true)
                ->wrap(),

            TextColumn::make('status_nyawa')
                ->label('Status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'hidup' => 'success',
                    'meninggal' => 'danger',
                    default => 'gray',
                })
                ->icon(fn(string $state): string => match ($state) {
                    'hidup' => 'heroicon-o-heart',
                    'meninggal' => 'heroicon-o-x-circle',
                    default => 'heroicon-o-question-mark-circle',
                })
                ->formatStateUsing(fn(string $state): string => match ($state) {
                    'hidup' => 'Hidup',
                    'meninggal' => 'Meninggal',
                    default => ucfirst($state),
                }),

            TextColumn::make('created_at')
                ->label('Terdaftar')
                ->dateTime('d M Y')
                ->sortable()
                ->toggleable(true),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            SelectFilter::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->native(false),

            SelectFilter::make('status_nyawa')
                ->label('Status Hidup')
                ->options([
                    'hidup' => 'Hidup',
                    'meninggal' => 'Meninggal',
                ])
                ->native(false),

            SelectFilter::make('agama')
                ->label('Agama')
                ->options([
                    'Islam' => 'Islam',
                    'Kristen' => 'Kristen',
                    'Katolik' => 'Katolik',
                    'Hindu' => 'Hindu',
                    'Buddha' => 'Buddha',
                    'Konghucu' => 'Konghucu',
                ])
                ->native(false),

            Filter::make('usia')
                ->form([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('usia_min')
                                ->label('Usia Minimal')
                                ->numeric()
                                ->placeholder('0'),
                            TextInput::make('usia_max')
                                ->label('Usia Maksimal')
                                ->numeric()
                                ->placeholder('100'),
                        ]),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['usia_min'],
                            fn(Builder $query, $usia): Builder => $query->whereDate('tanggal_lahir', '<=', now()->subYears($usia))
                        )
                        ->when(
                            $data['usia_max'],
                            fn(Builder $query, $usia): Builder => $query->whereDate('tanggal_lahir', '>=', now()->subYears($usia))
                        );
                }),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenduduks::route('/'),
            'create' => Pages\CreatePenduduk::route('/create'),
            'edit' => Pages\EditPenduduk::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->where('status_nyawa', 'hidup')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
