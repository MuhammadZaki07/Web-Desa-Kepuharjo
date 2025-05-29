<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendudukResource\Pages;
use App\Models\Penduduk;
use App\Imports\PendudukImport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\Action;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Support\Enums\ActionSize;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Forms\Components\MarkdownEditor;
use Maatwebsite\Excel\Facades\Excel;

class PendudukResource extends Resource
{
    protected static ?string $model = Penduduk::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data Penduduk';

    protected static ?string $modelLabel = 'Penduduk';

    protected static ?string $navigationGroup = "User Management";

    protected static ?int $navigationSort = 2;

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

                                TextInput::make('user.email')
                                    ->label('Email')
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                TextInput::make('user.phone')
                                    ->label('No. Telepon')
                                    ->tel()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(20)
                                    ->placeholder('08123456789'),

                                TextInput::make('user.password')
                                    ->label('Password')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                                    ->dehydrated(fn($state) => filled($state))
                                    ->required(fn(string $context): bool => $context === 'create')
                                    ->maxLength(255)
                                    ->placeholder('Kosongkan jika tidak ingin mengubah'),
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
                                    ->placeholder('Jakarta'),

                                DatePicker::make('tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->native(false)
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
                            ->placeholder('Jl. Contoh No. 123, Kelurahan ABC, Kecamatan XYZ')
                            ->columnSpanFull(),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('RT')
                                    ->label('RT')
                                    ->numeric()
                                    ->maxLength(3)
                                    ->placeholder('001'),

                                TextInput::make('RW')
                                    ->label('RW')
                                    ->numeric()
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
                                    ->options([
                                        'Belum Kawin' => 'Belum Kawin',
                                        'Kawin' => 'Kawin',
                                        'Cerai Hidup' => 'Cerai Hidup',
                                        'Cerai Mati' => 'Cerai Mati',
                                    ])
                                    ->native(false),

                                TextInput::make('pekerjaan')
                                    ->label('Pekerjaan')
                                    ->maxLength(255)
                                    ->placeholder('Pegawai Swasta'),

                                Select::make('pendidikan')
                                    ->label('Pendidikan Terakhir')
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
                Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        Section::make('Upload File Excel')
                            ->description('Pilih file Excel yang berisi data penduduk')
                            ->schema([
                                FileUpload::make('file')
                                    ->label('File Excel')
                                    ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', '.xlsx', '.xls'])
                                    ->required()
                                    ->helperText('Format file: .xlsx atau .xls')
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Petunjuk Format Excel')
                            ->description('Pastikan file Excel memiliki kolom-kolom berikut:')
                            ->schema([
                                MarkdownEditor::make('info')
                                    ->label(false)
                                    ->disabled()
                                    ->columnSpan(2)
                                    ->default("
    ### Kolom Wajib:
    - **nama_lengkap** (Nama lengkap penduduk)
    - **nik** (16 digit NIK)
    - **jenis_kelamin** (L/P atau Laki-laki/Perempuan)

    ### Kolom Opsional:
    - email, no_telepon, password
    - tempat_lahir, tanggal_lahir
    - alamat, rt, rw
    - agama, status_perkawinan, pekerjaan, pendidikan
    - catatan

    ### Catatan:
    - Baris pertama harus berisi header kolom
    - Tanggal lahir format: YYYY-MM-DD atau DD/MM/YYYY
    ")
                            ])
                            ->collapsible(),
                    ])
                    ->action(function (array $data) {
                        try {
                            $import = new PendudukImport();
                            Excel::import($import, $data['file']);

                            Notification::make()
                                ->title('Import Berhasil!')
                                ->body('Data penduduk berhasil diimport ke database.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                            $failures = $e->failures();
                            $errorMessages = [];

                            foreach ($failures as $failure) {
                                $errorMessages[] = "Baris {$failure->row()}: {$failure->errors()[0]}";
                            }

                            Notification::make()
                                ->title('Import Gagal!')
                                ->body('Terdapat kesalahan validasi: ' . implode(', ', array_slice($errorMessages, 0, 3)) . (count($errorMessages) > 3 ? '...' : ''))
                                ->danger()
                                ->duration(10000)
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Import Gagal!')
                                ->body('Terjadi kesalahan: ' . $e->getMessage())
                                ->danger()
                                ->duration(8000)
                                ->send();
                        }
                    })
                    ->modalWidth('4xl'),

                Action::make('download_template')
                    ->label('Template Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->action(function () {
                        return response()->streamDownload(function () {
                            $headers = [
                                'nama_lengkap',
                                'nik',
                                'jenis_kelamin',
                                'email',
                                'no_telepon',
                                'password',
                                'tempat_lahir',
                                'tanggal_lahir',
                                'alamat',
                                'rt',
                                'rw',
                                'agama',
                                'status_perkawinan',
                                'pekerjaan',
                                'pendidikan',
                                'catatan'
                            ];

                            $sample = [
                                'John Doe',
                                '1234567890123456',
                                'L',
                                'john@example.com',
                                '08123456789',
                                'password123',
                                'Jakarta',
                                '1990-01-15',
                                'Jl. Contoh No. 123',
                                '001',
                                '001',
                                'Islam',
                                'Belum Kawin',
                                'Programmer',
                                'S1',
                                'Contoh data'
                            ];

                            echo implode(',', $headers) . "\n";
                            echo implode(',', $sample) . "\n";
                        }, 'template_penduduk.csv', [
                            'Content-Type' => 'text/csv',
                        ]);
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->icon('heroicon-o-eye')
                        ->color('info'),
                    EditAction::make()
                        ->icon('heroicon-o-pencil')
                        ->color('warning'),
                    Action::make('toggle_status')
                        ->label(fn(Penduduk $record) => $record->status_nyawa === 'hidup' ? 'Tandai Meninggal' : 'Tandai Hidup')
                        ->icon(fn(Penduduk $record) => $record->status_nyawa === 'hidup' ? 'heroicon-o-x-circle' : 'heroicon-o-heart')
                        ->color(fn(Penduduk $record) => $record->status_nyawa === 'hidup' ? 'danger' : 'success')
                        ->action(function (Penduduk $record) {
                            $record->update([
                                'status_nyawa' => $record->status_nyawa === 'hidup' ? 'meninggal' : 'hidup'
                            ]);
                        })
                        ->requiresConfirmation()
                        ->modalDescription('Apakah Anda yakin ingin mengubah status hidup penduduk ini?'),
                    DeleteAction::make()
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ])
                    ->label('Aksi')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('gray')
                    ->button()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_alive')
                        ->label('Tandai Hidup')
                        ->icon('heroicon-o-heart')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['status_nyawa' => 'hidup']);
                        }),
                    Tables\Actions\BulkAction::make('mark_deceased')
                        ->label('Tandai Meninggal')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each->update(['status_nyawa' => 'meninggal']);
                        })
                        ->requiresConfirmation(),
                ]),
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
                ->searchable()
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
        return [
            //
        ];
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
        return static::getModel()::where('status_nyawa', 'hidup')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
