<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengurusDesaResource\Pages;
use App\Models\PengurusDesa;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class PengurusDesaResource extends Resource
{
    protected static ?string $model = PengurusDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Pengurus Desa';

    protected static ?string $modelLabel = 'Pengurus Desa';

    protected static ?string $pluralModelLabel = 'Pengurus Desa';

      protected static ?string $navigationGroup = "User Management";

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Jabatan')
                    ->description('Atur informasi jabatan pengurus desa')
                    ->icon('heroicon-o-briefcase')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Nama Pengurus')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->unique(User::class),
                                    ])
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $user = User::find($state);
                                            if ($user && $user->penduduk) {
                                                // You can add logic here if needed
                                            }
                                        }
                                    })
                                    ->columnSpan(2),

                                Select::make('jabatan')
                                    ->label('Jabatan')
                                    ->options(PengurusDesa::$jabatan_options)
                                    ->required()
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        // Auto-check availability
                                        if ($state && $get('is_wakil') !== null) {
                                            $isWakil = $get('is_wakil');
                                            if (!PengurusDesa::validateJabatanUnik($state, $isWakil)) {
                                                Notification::make()
                                                    ->title('Peringatan')
                                                    ->body('Jabatan ini sudah diisi oleh pengurus lain yang masih aktif.')
                                                    ->warning()
                                                    ->send();
                                            }
                                        }
                                    })
                                    ->prefixIcon('heroicon-o-identification'),

                                Toggle::make('is_wakil')
                                    ->label('Jabatan Wakil')
                                    ->helperText('Centang jika ini adalah jabatan wakil')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get) {
                                        $jabatan = $get('jabatan');
                                        if ($jabatan && $state !== null) {
                                            if (!PengurusDesa::validateJabatanUnik($jabatan, $state)) {
                                                Notification::make()
                                                    ->title('Peringatan')
                                                    ->body('Jabatan ini sudah diisi oleh pengurus lain yang masih aktif.')
                                                    ->warning()
                                                    ->send();
                                            }
                                        }
                                    }),
                            ]),

                        Placeholder::make('jabatan_preview')
                            ->label('Preview Jabatan')
                            ->content(function ($get) {
                                $jabatan = $get('jabatan');
                                $isWakil = $get('is_wakil');

                                if (!$jabatan) return '-';

                                $jabatanLabel = PengurusDesa::$jabatan_options[$jabatan] ?? $jabatan;
                                return $isWakil ? "Wakil {$jabatanLabel}" : $jabatanLabel;
                            })
                            ->live()
                            ->extraAttributes(['class' => 'font-bold text-primary-600']),
                    ]),

                Section::make('Masa Jabatan')
                    ->description('Tentukan periode masa jabatan')
                    ->icon('heroicon-o-calendar-days')
                    ->collapsible()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('mulai_jabatan')
                                    ->label('Mulai Jabatan')
                                    ->required()
                                    ->default(now())
                                    ->prefixIcon('heroicon-o-play-circle')
                                    ->displayFormat('d/m/Y'),

                                DatePicker::make('selesai_jabatan')
                                    ->label('Selesai Jabatan')
                                    ->helperText('Kosongkan jika masih aktif')
                                    ->prefixIcon('heroicon-o-stop-circle')
                                    ->displayFormat('d/m/Y')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $set('is_aktif', false);
                                        } else {
                                            $set('is_aktif', true);
                                        }
                                    }),
                            ]),

                        Toggle::make('is_aktif')
                            ->label('Status Aktif')
                            ->helperText('Pengurus yang sedang menjabat')
                            ->default(true)
                            ->live(),
                    ]),

                Section::make('Detail Tambahan')
                    ->description('Informasi pendukung lainnya')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Textarea::make('tugas_pokok')
                            ->label('Tugas Pokok')
                            ->helperText('Deskripsi tugas dan tanggung jawab utama')
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->helperText('Catatan atau keterangan tambahan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->icon('heroicon-o-user')
                    ->description(fn (PengurusDesa $record): string => $record->user->email ?? ''),

                BadgeColumn::make('jabatan_full')
                    ->label('Jabatan')
                    ->sortable(['jabatan', 'is_wakil'])
                    ->color(fn (string $state): string => match (true) {
                        str_contains(strtolower($state), 'kepala desa') => 'danger',
                        str_contains(strtolower($state), 'sekretaris') => 'warning',
                        str_contains(strtolower($state), 'bendahara') => 'success',
                        str_contains(strtolower($state), 'wakil') => 'gray',
                        default => 'primary',
                    })
                    ->icon(fn (string $state): string => match (true) {
                        str_contains(strtolower($state), 'kepala desa') => 'heroicon-o-user',
                        str_contains(strtolower($state), 'sekretaris') => 'heroicon-o-document-text',
                        str_contains(strtolower($state), 'bendahara') => 'heroicon-o-banknotes',
                        str_contains(strtolower($state), 'wakil') => 'heroicon-o-user-group',
                        default => 'heroicon-o-briefcase',
                    }),

                IconColumn::make('is_aktif')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('masa_jabatan')
                    ->label('Masa Jabatan')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-calendar-days')
                    ->tooltip(fn (PengurusDesa $record): string =>
                        "Durasi: {$record->durasi_jabatan}"
                    ),

                TextColumn::make('mulai_jabatan')
                    ->label('Mulai Jabatan')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable( true),

                TextColumn::make('selesai_jabatan')
                    ->label('Selesai Jabatan')
                    ->date('d M Y')
                    ->placeholder('Masih Aktif')
                    ->sortable()
                    ->toggleable( true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable( true),
            ])
            ->filters([
                SelectFilter::make('jabatan')
                    ->label('Jabatan')
                    ->options(PengurusDesa::$jabatan_options)
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_wakil')
                    ->label('Tipe Jabatan')
                    ->placeholder('Semua')
                    ->trueLabel('Wakil')
                    ->falseLabel('Utama'),

                TernaryFilter::make('is_aktif')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),

                SelectFilter::make('user_id')
                    ->label('Pengurus')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\EditAction::make()
                        ->icon('heroicon-o-pencil'),
                    Tables\Actions\Action::make('nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Non-aktifkan Pengurus')
                        ->modalSubheading('Pengurus akan dinonaktifkan dan masa jabatan akan berakhir hari ini.')
                        ->form([
                            Textarea::make('keterangan')
                                ->label('Alasan Non-aktif')
                                ->required()
                                ->placeholder('Masukkan alasan pengurus dinonaktifkan...')
                        ])
                        ->action(function (PengurusDesa $record, array $data) {
                            $record->nonAktifkan($data['keterangan']);

                            Notification::make()
                                ->title('Berhasil')
                                ->body("Pengurus {$record->user->name} telah dinonaktifkan.")
                                ->success()
                                ->send();
                        })
                        ->visible(fn (PengurusDesa $record): bool => $record->is_aktif),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('nonaktifkan_bulk')
                        ->label('Non-aktifkan Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Non-aktifkan Pengurus Terpilih')
                        ->modalSubheading('Semua pengurus yang dipilih akan dinonaktifkan.')
                        ->form([
                            Textarea::make('keterangan')
                                ->label('Alasan Non-aktif')
                                ->required()
                                ->placeholder('Masukkan alasan pengurus dinonaktifkan...')
                        ])
                        ->action(function ($records, array $data) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->is_aktif) {
                                    $record->nonAktifkan($data['keterangan']);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title('Berhasil')
                                ->body("{$count} pengurus telah dinonaktifkan.")
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('jabatan', 'asc')
            ->defaultSort('is_wakil', 'asc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->poll('30s')
            ->deferLoading()
            ->persistSortInSession()
            ->persistSearchInSession()
            ->persistFiltersInSession();
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
            'index' => Pages\ListPengurusDesas::route('/'),
            'create' => Pages\CreatePengurusDesa::route('/create'),
            'edit' => Pages\EditPengurusDesa::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::aktif()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 10 ? 'warning' : 'primary';
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name', 'jabatan', 'keterangan'];
    }
}
