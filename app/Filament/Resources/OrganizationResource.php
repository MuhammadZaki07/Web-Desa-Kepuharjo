<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Gallery;
use App\Models\Organization;
use App\Models\Penduduk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Organisasi';
    protected static ?string $pluralLabel = 'Organisasi';
    protected static ?string $label = 'Organisasi';
    protected static ?string $navigationGroup = 'Profil & Identitas Desa';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('organization_tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('PKK')
                            ->schema(static::getPkkFormSchema())
                            ->visible(function ($livewire) {
                                // Untuk create: tampilkan jika belum ada data PKK
                                if ($livewire instanceof \Filament\Resources\Pages\CreateRecord) {
                                    return !Organization::hasType('pkk');
                                }

                                // Untuk edit: tampilkan jika record yang sedang diedit adalah PKK
                                if ($livewire instanceof \Filament\Resources\Pages\EditRecord) {
                                    return $livewire->record->type === 'pkk';
                                }

                                return false;
                            }),

                        Forms\Components\Tabs\Tab::make('Karang Taruna')
                            ->schema(static::getKarangTarunaFormSchema())
                            ->visible(function ($livewire) {
                                // Untuk create: tampilkan jika belum ada data Karang Taruna
                                if ($livewire instanceof \Filament\Resources\Pages\CreateRecord) {
                                    return !Organization::hasType('karang_taruna');
                                }

                                // Untuk edit: tampilkan jika record yang sedang diedit adalah Karang Taruna
                                if ($livewire instanceof \Filament\Resources\Pages\EditRecord) {
                                    return $livewire->record->type === 'karang_taruna';
                                }

                                return false;
                            }),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis Organisasi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pkk' => 'success',
                        'karang_taruna' => 'info',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pkk' => 'PKK',
                        'karang_taruna' => 'Karang Taruna',
                    }),

                Tables\Columns\TextColumn::make('contact_phone')
                    ->label('Kontak')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Jenis Organisasi')
                    ->options([
                        'pkk' => 'PKK',
                        'karang_taruna' => 'Karang Taruna',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function getPkkFormSchema(): array
    {
        return [
            Forms\Components\Hidden::make('type')
                ->default('pkk'),

            Forms\Components\Section::make('Informasi PKK')
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Deskripsi PKK')
                        ->placeholder('Masukkan deskripsi lengkap tentang PKK desa...')
                        ->required()
                        ->toolbarButtons([
                            'h1',
                            'h2',
                            'link',
                            'paragraph',
                        ])
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('contact_phone')
                        ->label('No. Telepon Kontak')
                        ->placeholder('Contoh: 0812-3456-7890')
                        ->tel(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Struktur Kepengurusan PKK')
                ->schema([
                    Forms\Components\Repeater::make('structure')
                        ->label('')
                        ->schema([
                            Forms\Components\TextInput::make('jabatan')
                                ->label('Jabatan')
                                ->placeholder('Contoh: Ketua, Wakil Ketua, Koordinator Pokja I')
                                ->required(),

                            Forms\Components\Select::make('nama')
                                ->label('Nama')
                                ->placeholder('Pilih atau ketik nama...')
                                ->searchable()
                                ->getSearchResultsUsing(
                                    fn(string $search): array =>
                                    \App\Models\User::where('name', 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck('name', 'name')
                                        ->toArray()
                                )
                                ->getOptionLabelUsing(fn($value): ?string => $value)
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nama')
                                        ->required(),
                                ])
                                ->createOptionUsing(function (array $data): string {
                                    return $data['name'];
                                })
                                ->required(),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(
                            fn(array $state): ?string =>
                            !empty($state['jabatan']) && !empty($state['nama'])
                                ? "{$state['jabatan']}: {$state['nama']}"
                                : null
                        )
                        ->addActionLabel('Tambah Pengurus')
                        ->required()
                        ->minItems(1),
                ]),

            Forms\Components\Repeater::make('programs')
                ->label('')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Program')
                        ->placeholder('Contoh: Pemberdayaan Ekonomi Kreatif Pemuda')
                        ->required()
                        ->hiddenLabel(),
                ])
                ->reorderable()
                ->addActionLabel('Tambah Program')
                ->deleteAction(
                    fn(Forms\Components\Actions\Action $action) => $action
                        ->requiresConfirmation()
                )
                ->required()
                ->minItems(1)
                ->default([['name' => '']]),


            Forms\Components\Repeater::make('activities')
                ->label('')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Kegiatan')
                        ->placeholder('Contoh: Kerja bakti setiap minggu')
                        ->required()
                        ->hiddenLabel(),
                ])
                ->reorderable()
                ->addActionLabel('Tambah Kegiatan')
                ->deleteAction(
                    fn(Forms\Components\Actions\Action $action) => $action
                        ->requiresConfirmation()
                )
                ->required()
                ->minItems(1)
                ->default([['name' => '']]),

            Forms\Components\Section::make('Gallery PKK')
                ->schema([
                    Forms\Components\FileUpload::make('gallery_photos')
                        ->label('Upload Foto Kegiatan')
                        ->image()
                        ->multiple()
                        ->directory('organizations/pkk')
                        ->visibility('public')
                        ->imageEditor()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                foreach ($state as $path) {
                                    Gallery::create([
                                        'path' => $path,
                                        'type' => 'pkk'
                                    ]);
                                }
                            }
                        })
                        ->helperText('Pilih satu atau beberapa foto kegiatan PKK'),
                ])
                ->collapsible(),
        ];
    }

    protected static function getKarangTarunaFormSchema(): array
    {
        return [
            Forms\Components\Hidden::make('type')
                ->default('karang_taruna'),

            Forms\Components\Section::make('Informasi Karang Taruna')
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Deskripsi Karang Taruna')
                        ->placeholder('Masukkan deskripsi lengkap tentang Karang Taruna desa...')
                        ->required()
                        ->toolbarButtons([
                            'h1',
                            'h2',
                            'link',
                            'paragraph',
                        ])
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('contact_phone')
                        ->label('No. Telepon Kontak')
                        ->placeholder('Contoh: 0812-3456-7890')
                        ->tel(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Struktur Kepengurusan Karang Taruna')
                ->schema([
                    Forms\Components\Repeater::make('structure')
                        ->label('')
                        ->schema([
                            Forms\Components\TextInput::make('jabatan')
                                ->label('Jabatan')
                                ->placeholder('Contoh: Ketua, Wakil Ketua, Koordinator Sosial')
                                ->required(),

                            Forms\Components\Select::make('nama')
                                ->label('Nama')
                                ->placeholder('Pilih atau ketik nama...')
                                ->searchable()
                                ->getSearchResultsUsing(
                                    fn(string $search): array =>
                                    \App\Models\User::where('name', 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck('name', 'name')
                                        ->toArray()
                                )
                                ->getOptionLabelUsing(fn($value): ?string => $value)
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Nama')
                                        ->required(),
                                ])
                                ->createOptionUsing(function (array $data): string {
                                    return $data['name'];
                                })
                                ->required(),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->collapsible()
                        ->itemLabel(
                            fn(array $state): ?string =>
                            !empty($state['jabatan']) && !empty($state['nama'])
                                ? "{$state['jabatan']}: {$state['nama']}"
                                : null
                        )
                        ->addActionLabel('Tambah Pengurus')
                        ->required()
                        ->minItems(1),
                ]),

            Forms\Components\Section::make('Program Unggulan Karang Taruna')
                ->schema([
                    Forms\Components\Repeater::make('programs')
                        ->label('')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Program')
                                ->placeholder('Contoh: Pemberdayaan Ekonomi Kreatif Pemuda')
                                ->required()
                                ->hiddenLabel(),
                        ])
                        ->reorderable()
                        ->addActionLabel('Tambah Program')
                        ->deleteAction(
                            fn(Forms\Components\Actions\Action $action) => $action
                                ->requiresConfirmation()
                                ->hidden(
                                    fn(Forms\Components\Repeater $component): bool =>
                                    $component->getState() !== null && count($component->getState()) <= 1
                                )
                        )
                        ->required()
                        ->minItems(1),
                ]),

            Forms\Components\Section::make('Kegiatan Rutin Karang Taruna')
                ->schema([
                    Forms\Components\Repeater::make('activities')
                        ->label('')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kegiatan')
                                ->placeholder('Contoh: Kerja bakti setiap minggu')
                                ->required()
                                ->hiddenLabel(),
                        ])
                        ->reorderable()
                        ->addActionLabel('Tambah Kegiatan')
                        ->deleteAction(
                            fn(Forms\Components\Actions\Action $action) => $action
                                ->requiresConfirmation()
                                ->hidden(
                                    fn(Forms\Components\Repeater $component): bool =>
                                    $component->getState() !== null && count($component->getState()) <= 1
                                )
                        )
                        ->required()
                        ->minItems(1),
                ]),

            Forms\Components\Section::make('Gallery Karang Taruna')
                ->schema([
                    Forms\Components\FileUpload::make('gallery_photos')
                        ->label('Upload Foto Kegiatan')
                        ->image()
                        ->multiple()
                        ->directory('organizations/karang_taruna')
                        ->visibility('public')
                        ->imageEditor()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                foreach ($state as $path) {
                                    Gallery::create([
                                        'path' => $path,
                                        'type' => 'karang_taruna'
                                    ]);
                                }
                            }
                        })
                        ->helperText('Pilih satu atau beberapa foto kegiatan Karang Taruna'),
                ])
                ->collapsible(),
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
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
