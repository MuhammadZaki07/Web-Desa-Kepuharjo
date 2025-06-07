<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanResource\Pages;
use App\Models\Pengajuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class PengajuanResource extends Resource
{
    protected static ?string $model = Pengajuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Pengajuan Warga';

    protected static ?string $modelLabel = 'Pengajuan';

    protected static ?string $pluralModelLabel = 'Pengajuan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('no_tlp')
                    ->label('Nomor Telepon')
                    ->required()
                    ->maxLength(20),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(4),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'diproses' => 'Sedang Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('no_tlp')
                    ->label('No. Telepon')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor telepon berhasil disalin!'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'diproses',
                        'success' => 'selesai',
                        'danger' => 'ditolak',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Menunggu',
                        'diproses' => 'Sedang Diproses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),

                Tables\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn(Pengajuan $record): string => $record->whatsapp_url)
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make()
                    ->label('Edit Status')
                    ->modalHeading('Edit Status Pengajuan')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Menunggu',
                                'diproses' => 'Sedang Diproses',
                                'selesai' => 'Selesai',
                                'ditolak' => 'Ditolak',
                            ])
                            ->required(),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s'); // Auto refresh setiap 30 detik
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Pengajuan')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('ID Pengajuan')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('created_at')
                                    ->label('Tanggal Pengajuan')
                                    ->dateTime('d M Y H:i'),

                                TextEntry::make('name')
                                    ->label('Nama Lengkap')
                                    ->size('lg')
                                    ->weight('bold'),

                                TextEntry::make('no_tlp')
                                    ->label('Nomor Telepon')
                                    ->copyable()
                                    ->copyMessage('Nomor telepon berhasil disalin!'),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'diproses' => 'primary',
                                        'selesai' => 'success',
                                        'ditolak' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn(string $state): string => match ($state) {
                                        'pending' => 'Menunggu',
                                        'diproses' => 'Sedang Diproses',
                                        'selesai' => 'Selesai',
                                        'ditolak' => 'Ditolak',
                                        default => $state,
                                    }),
                            ]),

                        TextEntry::make('description')
                            ->label('Deskripsi Pengajuan')
                            ->prose()
                            ->markdown(),
                    ]),

                Section::make('Bukti Gambar')
                    ->schema([
                        TextEntry::make('images')
                            ->label('')
                            ->formatStateUsing(function ($state, $record) {
                                // Gunakan $record->images yang adalah array asli, bukan $state yang sudah jadi string
                                $images = $record->images;

                                if (empty($images) || !is_array($images)) {
                                    return '<div class="text-gray-500 text-center py-8 border border-gray-200 rounded-lg bg-gray-50">
                                <p class="text-sm">Tidak ada bukti gambar yang diunggah</p>
                            </div>';
                                }

                                $html = '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">';
                                foreach ($images as $imagePath) {
                                    $imageUrl = asset('storage/' . $imagePath);
                                    $html .= '
                                    <a href="' . $imageUrl . '" target="_blank">
                                        <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                            <img
                                                src="' . $imageUrl . '"
                                                alt="Bukti Gambar"
                                                class="w-full h-48 object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                                style="max-width: 100%; height: 200px;"
                                                onerror="this.parentElement.innerHTML=\'<div class=&quot;flex items-center justify-center h-48 bg-gray-100 text-gray-500&quot;><span>Gambar tidak ditemukan</span></div>\'"
                                            >
                                        </div>
                                    </a>';
                                }
                                $html .= '</div>';

                                return $html;
                            })
                            ->html()
                            ->visible(fn(Pengajuan $record): bool => !empty($record->images) && is_array($record->images)),

                        TextEntry::make('no_images')
                            ->label('')
                            ->default('Tidak ada bukti gambar yang diunggah')
                            ->color('gray')
                            ->visible(fn(Pengajuan $record): bool => empty($record->images) || !is_array($record->images)),
                    ]),

                Section::make('Aksi Cepat')
                    ->schema([
                        Infolists\Components\Actions::make([
                            Infolists\Components\Actions\Action::make('whatsapp')
                                ->label('Hubungi via WhatsApp')
                                ->icon('heroicon-o-chat-bubble-left-right')
                                ->color('success')
                                ->url(fn(Pengajuan $record): string => $record->whatsapp_url)
                                ->openUrlInNewTab(),

                            Infolists\Components\Actions\Action::make('edit_status')
                                ->label('Ubah Status')
                                ->icon('heroicon-o-pencil-square')
                                ->color('warning')
                                ->form([
                                    Forms\Components\Select::make('status')
                                        ->label('Status Baru')
                                        ->options([
                                            'pending' => 'Menunggu',
                                            'diproses' => 'Sedang Diproses',
                                            'selesai' => 'Selesai',
                                            'ditolak' => 'Ditolak',
                                        ])
                                        ->default(fn(Pengajuan $record): string => $record->status)
                                        ->required(),
                                ])
                                ->action(function (array $data, Pengajuan $record): void {
                                    $record->update(['status' => $data['status']]);
                                })
                                ->successNotificationTitle('Status berhasil diubah'),
                        ]),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajuans::route('/'),
            'view' => Pages\ViewPengajuan::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() > 0 ? 'warning' : 'success';
    }
}
