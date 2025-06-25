<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

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
                                if ($livewire instanceof \Filament\Resources\Pages\CreateRecord) {
                                    return !Organization::hasType('pkk');
                                }
                                if ($livewire instanceof \Filament\Resources\Pages\EditRecord) {
                                    return $livewire->record->type === 'pkk';
                                }
                                return false;
                            }),

                        Forms\Components\Tabs\Tab::make('Karang Taruna')
                            ->schema(static::getKarangTarunaFormSchema())
                            ->visible(function ($livewire) {
                                if ($livewire instanceof \Filament\Resources\Pages\CreateRecord) {
                                    return !Organization::hasType('karang_taruna');
                                }
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
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime()
                    ->sortable(),
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
    ->default('pkk')
    ->dehydrated() // dikirim ke backend
    ->required(),



            Forms\Components\Section::make('Informasi PKK')
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Deskripsi PKK')
                        ->required()
                        ->lazy()
                        ->toolbarButtons(['h1', 'h2', 'link', 'paragraph'])
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('contact_phone')
                        ->label('No. Telepon Kontak')
                        ->tel(),
                ])
                ->columns(2),

            ...static::getRepeaterSchemas(),
        ];
    }

    protected static function getKarangTarunaFormSchema(): array
    {
        return [
           Forms\Components\Hidden::make('type')
    ->default('karang_taruna')
    ->dehydrated()
    ->required(),



            Forms\Components\Section::make('Informasi Karang Taruna')
                ->schema([
                    Forms\Components\RichEditor::make('content')
                        ->label('Deskripsi Karang Taruna')
                        ->required()
                        ->lazy()
                        ->toolbarButtons(['h1', 'h2', 'link', 'paragraph'])
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('contact_phone')
                        ->label('No. Telepon Kontak')
                        ->tel(),
                ])
                ->columns(2),

            ...static::getRepeaterSchemas(),
        ];
    }

    protected static function getRepeaterSchemas(): array
    {
        return [
            Forms\Components\Section::make('Struktur Kepengurusan')
                ->schema([
                    Forms\Components\Repeater::make('structure')
                        ->schema([
                            Forms\Components\TextInput::make('jabatan')->required(),
                            Forms\Components\Select::make('nama')
                                ->searchable()
                                ->getSearchResultsUsing(fn(string $search): array =>
                                \App\Models\User::where('name', 'like', "%{$search}%")
                                    ->pluck('name', 'name')
                                    ->toArray())
                                ->getOptionLabelUsing(fn($value) => $value)
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')->required(),
                                ])
                                ->createOptionUsing(fn(array $data) => $data['name'])
                                ->required(),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->collapsible()
                        ->required()
                        ->minItems(1),
                ]),

            Forms\Components\Repeater::make('programs')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->hiddenLabel(),
                ])
                ->reorderable()
                ->addActionLabel('Tambah Program')
                ->required()
                ->minItems(1),

            Forms\Components\Repeater::make('activities')
                ->schema([
                    Forms\Components\TextInput::make('name')->required()->hiddenLabel(),
                ])
                ->reorderable()
                ->addActionLabel('Tambah Kegiatan')
                ->required()
                ->minItems(1),
        ];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
