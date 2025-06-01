<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = "Admin";
    protected static ?string $navigationGroup = "User Management";
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('form_mode')
                    ->default('create_new'),

                Tabs::make('admin_tabs')
                    ->tabs([
                        Tab::make('create_new_user')
                            ->label('Buat Admin Baru')
                            ->icon('heroicon-o-plus-circle')
                            ->schema([
                                Section::make('Informasi Admin Baru')
                                    ->description('Buat akun admin baru dengan data lengkap')
                                    ->icon('heroicon-o-user-plus')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('user.name')
                                                    ->label('Nama Lengkap')
                                                    ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'create_new')
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan nama lengkap'),

                                                TextInput::make('user.email')
                                                    ->label('Email')
                                                    ->email()
                                                    ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'create_new')
                                                    ->unique(User::class, 'email', ignoreRecord: true)
                                                    ->maxLength(255)
                                                    ->placeholder('admin@example.com'),

                                                TextInput::make('user.phone')
                                                    ->label('No. Telepon')
                                                    ->unique(User::class, 'phone', ignoreRecord: true)
                                                    ->maxLength(255)
                                                    ->placeholder('08xxxxxxxxxx'),

                                                TextInput::make('user.password')
                                                    ->label('Password')
                                                    ->password()
                                                    ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'create_new')
                                                    ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : null)
                                                    ->dehydrated(fn($state) => filled($state))
                                                    ->minLength(6)
                                                    ->maxLength(255)
                                                    ->placeholder('Minimal 6 karakter'),

                                                Select::make('user.jabatan')
                                                    ->label('Level Jabatan')
                                                    ->options([
                                                        'super_admin' => 'Super Admin',
                                                        'admin_desa' => 'Admin Desa',
                                                        'operator' => 'Operator',
                                                    ])
                                                    ->default('admin_desa')
                                                    ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'create_new')
                                                    ->searchable(),

                                                FileUpload::make('user.photo')
                                                    ->label('Foto Profile')
                                                    ->image()
                                                    ->directory('admin-photos')
                                                    ->visibility('private')
                                                    ->maxSize(2048)
                                                    ->imageEditor()
                                                    ->columnSpanFull(),
                                            ])
                                    ])
                            ])
                            ->extraAttributes([
                                'x-on:click' => '$wire.set("data.form_mode", "create_new")'
                            ])
                            ->visible(fn($operation) => $operation === 'create'),

                        Tab::make('promote_existing_user')
                            ->label('Promote Penduduk')
                            ->icon('heroicon-o-arrow-up-circle')
                            ->schema([
                                Section::make('Promote Penduduk Menjadi Admin')
                                    ->description('Pilih penduduk yang akan dipromote menjadi admin dan buatkan akun login')
                                    ->icon('heroicon-o-user-group')
                                    ->schema([
                                        Grid::make(1)
                                            ->schema([
                                                Select::make('existing_user_id')
                                                    ->label('Pilih Penduduk')
                                                    ->placeholder('Pilih penduduk yang akan dijadikan admin...')
                                                    ->searchable()
                                                    ->preload(false) // Disable preloading for better performance
                                                    ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'promote_existing')
                                                    ->options(function () {
                                                        // Use caching for options
                                                        return Cache::remember('admin_resource_available_users', 300, function () {
                                                            return User::where('role', 'penduduk')
                                                                ->whereDoesntHave('admin')
                                                                ->orderBy('name')
                                                                ->limit(50) // Reduced limit for better performance
                                                                ->pluck('name', 'id')
                                                                ->toArray();
                                                        });
                                                    })
                                                    ->getSearchResultsUsing(
                                                        fn(string $search): array =>
                                                        User::where('role', 'penduduk')
                                                            ->where(function ($query) use ($search) {
                                                                $query->where('name', 'like', "%{$search}%")
                                                                    ->orWhere('nik', 'like', "%{$search}%")
                                                                    ->orWhere('phone', 'like', "%{$search}%");
                                                            })
                                                            ->whereDoesntHave('admin')
                                                            ->limit(25) // Reduced limit for search results
                                                            ->pluck('name', 'id')
                                                            ->toArray()
                                                    )
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, $set) {
                                                        if ($state) {
                                                            $user = User::with('penduduk')->find($state); // Use eager loading
                                                            if ($user) {
                                                                $set('preview_name', $user->name);
                                                                $set('preview_nik', $user->penduduk->nik ?? 'N/A');
                                                                $set('preview_phone', $user->phone);
                                                                $set('preview_address', $user->penduduk->alamat ?? 'N/A');
                                                            }
                                                        } else {
                                                            $set('preview_name', null);
                                                            $set('preview_nik', null);
                                                            $set('preview_phone', null);
                                                            $set('preview_address', null);
                                                        }
                                                    }),
                                            ]),

                                        Section::make('Preview Data Penduduk')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Placeholder::make('preview_name')
                                                            ->label('Nama Lengkap')
                                                            ->content(fn($get) => $get('preview_name') ?: 'Belum dipilih'),

                                                        Placeholder::make('preview_nik')
                                                            ->label('NIK')
                                                            ->content(fn($get) => $get('preview_nik') ?: 'Belum dipilih'),

                                                        Placeholder::make('preview_phone')
                                                            ->label('No. Telepon')
                                                            ->content(fn($get) => $get('preview_phone') ?: 'Belum dipilih'),

                                                        Placeholder::make('preview_address')
                                                            ->label('Alamat')
                                                            ->content(fn($get) => $get('preview_address') ?: 'Belum dipilih'),
                                                    ])
                                            ])
                                            ->visible(fn($get) => filled($get('existing_user_id')))
                                            ->collapsible()
                                            ->collapsed(false),

                                        Section::make('Data Login Admin')
                                            ->description('Buatkan email dan password untuk login admin')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('admin_email')
                                                            ->label('Email Admin')
                                                            ->email()
                                                            ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'promote_existing')
                                                            ->unique(User::class, 'email', ignoreRecord: true)
                                                            ->placeholder('admin@desa.com')
                                                            ->helperText('Email untuk login ke sistem'),

                                                        TextInput::make('admin_password')
                                                            ->label('Password')
                                                            ->password()
                                                            ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'promote_existing')
                                                            ->minLength(6)
                                                            ->placeholder('Minimal 6 karakter')
                                                            ->helperText('Password untuk login ke sistem'),

                                                        Select::make('new_jabatan')
                                                            ->label('Level Jabatan')
                                                            ->options([
                                                                'super_admin' => 'Super Admin',
                                                                'admin_desa' => 'Admin Desa',
                                                                'operator' => 'Operator',
                                                            ])
                                                            ->default('admin_desa')
                                                            ->required(fn(Get $get, $operation) => $operation === 'create' && $get('form_mode') === 'promote_existing')
                                                            ->searchable(),

                                                        FileUpload::make('admin_photo')
                                                            ->label('Update Foto (Opsional)')
                                                            ->image()
                                                            ->directory('admin-photos')
                                                            ->visibility('private')
                                                            ->maxSize(2048)
                                                            ->imageEditor()
                                                            ->helperText('Kosongkan jika tidak ingin mengubah foto'),
                                                    ])
                                            ])
                                            ->visible(fn($get) => filled($get('existing_user_id'))),
                                    ]),
                            ])
                            ->extraAttributes([
                                'x-on:click' => '$wire.set("data.form_mode", "promote_existing")'
                            ])
                            ->visible(fn($operation) => $operation === 'create'),
                    ])
                    ->columnSpanFull()
                    ->visible(fn($operation) => $operation === 'create'),

                Section::make('Edit Data Admin')
                    ->description('Update informasi admin')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('user.name')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('user.email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique(User::class, 'email',  fn($record) => $record?->user)
                                    ->maxLength(255),

                                TextInput::make('user.phone')
                                    ->label('No. Telepon')
                                    ->unique(User::class, 'phone',  fn($record) => $record?->user)
                                    ->maxLength(255),

                                TextInput::make('user.password')
                                    ->label('Password Baru')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : null)
                                    ->dehydrated(fn($state) => filled($state))
                                    ->minLength(6)
                                    ->maxLength(255)
                                    ->placeholder('Kosongkan jika tidak ingin mengubah')
                                    ->helperText('Kosongkan jika tidak ingin mengubah password'),

                                Select::make('user.jabatan')
                                    ->label('Level Jabatan')
                                    ->options([
                                        'super_admin' => 'Super Admin',
                                        'admin_desa' => 'Admin Desa',
                                        'operator' => 'Operator',
                                    ])
                                    ->required()
                                    ->searchable(),

                                FileUpload::make('user.photo')
                                    ->label('Foto Profile')
                                    ->image()
                                    ->directory('admin-photos')
                                    ->visibility('private')
                                    ->maxSize(2048)
                                    ->imageEditor()
                                    ->columnSpanFull(),
                            ])
                    ])
                    ->visible(fn($operation) => $operation === 'edit'),

                Section::make('Informasi Tambahan')
                    ->description('Detail posisi dan status admin')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('position')
                                    ->label('Posisi/Jabatan Detail')
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Sekretaris Desa, Kepala Desa, dll')
                                    ->helperText('Posisi spesifik dalam struktur organisasi'),

                                Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true)
                                    ->helperText('Admin aktif dapat mengakses sistem'),
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('user.photo')
                    ->label('Foto')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=' . urlencode('Admin') . '&color=7F9CF5&background=EBF4FF'),

                TextColumn::make('user.name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('sm'),

                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-o-envelope')
                    ->iconColor('gray')
                    ->size('sm'),

                TextColumn::make('user.phone')
                    ->label('Telepon')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone')
                    ->iconColor('gray')
                    ->size('sm'),

                TextColumn::make('user.jabatan')
                    ->label('Level Jabatan')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin_desa' => 'success',
                        'operator' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'admin_desa' => 'Admin Desa',
                        'operator' => 'Operator',
                        default => ucfirst($state),
                    }),

                TextColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Non Aktif')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->icon(fn($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(true),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Non Aktif',
                    ]),
                SelectFilter::make('jabatan')
                    ->label('Level Jabatan')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'admin_desa' => 'Admin Desa',
                        'operator' => 'Operator',
                    ])
                    ->query(function ($query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('user', function ($q) use ($data) {
                                $q->where('jabatan', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->icon('heroicon-o-pencil')
                        ->color('warning'),
                    Action::make('toggle_status')
                        ->label(fn(Admin $record) => $record->is_active ? 'Nonaktifkan' : 'Aktifkan')
                        ->icon(fn(Admin $record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn(Admin $record) => $record->is_active ? 'danger' : 'success')
                        ->action(function (Admin $record) {
                            $record->update(['is_active' => !$record->is_active]);
                            // Clear cache after status change
                            Cache::forget('admin_navigation_badge_count');
                        })
                        ->requiresConfirmation()
                        ->modalDescription('Apakah Anda yakin ingin mengubah status admin ini?'),
                    DeleteAction::make()
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->visible(function () {
                            return Auth::user() && Auth::user()->jabatan === 'super_admin';
                        })
                        ->action(function (Admin $record) {
                            $totalActiveAdmins = Admin::whereHas('user', function ($query) {
                                $query->where('is_active', true);
                            })->count();

                            if ($record->is_active && $totalActiveAdmins <= 1) {
                                Notification::make()
                                    ->title('Gagal Menghapus')
                                    ->body('Tidak dapat menghapus admin terakhir. Minimal harus ada 1 admin aktif untuk mengelola sistem.')
                                    ->danger()
                                    ->send();
                                return false;
                            }

                            $totalAdmins = Admin::count();
                            if ($totalAdmins <= 1) {
                                Notification::make()
                                    ->title('Gagal Menghapus')
                                    ->body('Tidak dapat menghapus admin terakhir. Sistem membutuhkan minimal 1 admin.')
                                    ->danger()
                                    ->send();
                                return false;
                            }

                            $record->delete();
                            // Clear cache after deletion
                            Cache::forget('admin_navigation_badge_count');

                            Notification::make()
                                ->title('Berhasil')
                                ->body('Admin berhasil dihapus.')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Admin')
                        ->modalDescription('Apakah Anda yakin ingin menghapus admin ini? Tindakan ini tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Ya, Hapus'),
                ])
                    ->label('Aksi')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('gray')
                    ->button()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(function () {
                            return Auth::user() && Auth::user()->jabatan === 'super_admin';
                        })
                        ->action(function ($records) {
                            $recordsToDelete = collect($records);
                            $totalAdmins = Admin::count();
                            $totalActiveAdmins = Admin::whereHas('user', function ($query) {
                                $query->where('is_active', true);
                            })->count();

                            $activeRecordsToDelete = $recordsToDelete->filter(function ($record) {
                                return $record->is_active;
                            })->count();

                            if ($recordsToDelete->count() >= $totalAdmins) {
                                Notification::make()
                                    ->title('Gagal Menghapus')
                                    ->body('Tidak dapat menghapus semua admin. Sistem membutuhkan minimal 1 admin.')
                                    ->danger()
                                    ->send();
                                return false;
                            }

                            if ($activeRecordsToDelete >= $totalActiveAdmins) {
                                Notification::make()
                                    ->title('Gagal Menghapus')
                                    ->body('Tidak dapat menghapus semua admin aktif. Minimal harus ada 1 admin aktif untuk mengelola sistem.')
                                    ->danger()
                                    ->send();
                                return false;
                            }

                            foreach ($recordsToDelete as $record) {
                                $record->delete();
                            }

                            // Clear cache after bulk deletion
                            Cache::forget('admin_navigation_badge_count');

                            Notification::make()
                                ->title('Berhasil')
                                ->body($recordsToDelete->count() . ' admin berhasil dihapus.')
                                ->success()
                                ->send();
                        }),
                    BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => true]);
                            // Clear cache after bulk activation
                            Cache::forget('admin_navigation_badge_count');
                        }),
                    BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $recordsToDeactivate = collect($records);
                            $totalActiveAdmins = Admin::whereHas('user', function ($query) {
                                $query->where('is_active', true);
                            })->count();

                            $activeRecordsToDeactivate = $recordsToDeactivate->filter(function ($record) {
                                return $record->is_active;
                            })->count();

                            if ($activeRecordsToDeactivate >= $totalActiveAdmins) {
                                Notification::make()
                                    ->title('Gagal Menonaktifkan')
                                    ->body('Tidak dapat menonaktifkan semua admin aktif. Minimal harus ada 1 admin aktif untuk mengelola sistem.')
                                    ->danger()
                                    ->send();
                                return false;
                            }

                            $records->each->update(['is_active' => false]);
                            // Clear cache after bulk deactivation
                            Cache::forget('admin_navigation_badge_count');
                        }),
                ]),
            ])
            ->emptyStateHeading('Belum ada data admin')
            ->emptyStateDescription('Mulai dengan membuat admin pertama untuk mengelola sistem.')
            ->emptyStateIcon('heroicon-o-shield-check');
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // Cache the navigation badge count to prevent duplicate queries
        return Cache::remember('admin_navigation_badge_count', 300, function () {
            return static::getModel()::where('is_active', true)->count();
        });
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
