<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileDesaResource\Pages;
use App\Models\ProfileDesa;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProfileDesaResource extends Resource
{
    protected static ?string $model = ProfileDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Profile Desa';

    protected static ?string $navigationGroup = 'Profil & Identitas Desa';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $socialMediaData = DB::table('sosial_media')->pluck('url', 'platform')->toArray();

        return $form
            ->schema([
                Section::make('🏛️ Identitas Desa')
                    ->description('Informasi dasar tentang desa dan kontak resmi')
                    ->icon('heroicon-o-identification')
                    ->collapsed(false)
                    ->collapsible(true)
                    ->schema([
                        Grid::make(3)->schema([
                            Card::make()
                                ->schema([
                                    FileUpload::make('logo_desa')
                                        ->label('Logo Desa')
                                        ->image()
                                        ->directory('desa-logos')
                                        ->disk('public')
                                        ->visibility('public')
                                        ->maxSize(2048)
                                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                        ->imagePreviewHeight('120')
                                        ->imageResizeTargetWidth('200')
                                        ->imageResizeTargetHeight('200')
                                        ->imageCropAspectRatio('1:1')
                                        ->panelLayout('compact')
                                        ->panelAspectRatio('1:1')
                                        ->uploadButtonPosition('bottom')
                                        ->openable()
                                        ->downloadable()
                                        ->required()
                                        ->helperText('Upload logo desa dengan format PNG/JPEG. Maksimal 2MB.')
                                ])
                                ->columnSpan(1),

                            Grid::make(1)->schema([
                                TextInput::make('name')
                                    ->label('Nama Desa')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Desa Sumberagung')
                                    ->helperText('Nama resmi desa sesuai dokumen')
                                    ->prefixIcon('heroicon-o-map-pin'),

                                Grid::make(2)->schema([
                                    TextInput::make('email')
                                        ->label('Email Resmi')
                                        ->email()
                                        ->required()
                                        ->maxLength(255)
                                        ->placeholder('desa@example.com')
                                        ->unique(ignoreRecord: true)
                                        ->prefixIcon('heroicon-o-envelope')
                                        ->helperText('Email resmi untuk komunikasi desa'),

                                    TextInput::make('no_tlp')
                                        ->label('No. Telepon Desa')
                                        ->tel()
                                        ->required()
                                        ->maxLength(20)
                                        ->placeholder('021-12345678')
                                        ->unique(ignoreRecord: true)
                                        ->prefixIcon('heroicon-o-phone')
                                        ->helperText('Nomor telepon kantor desa'),
                                ]),

                                Grid::make(2)->schema([
                                    TextInput::make('website')
                                        ->label('Website Desa')
                                        ->url()
                                        ->maxLength(255)
                                        ->placeholder('https://desa.example.com')
                                        ->prefixIcon('heroicon-o-globe-alt')
                                        ->helperText('Website resmi desa (opsional)'),

                                    TextInput::make('kode_pos')
                                        ->label('Kode Pos')
                                        ->numeric()
                                        ->maxLength(10)
                                        ->placeholder('12345')
                                        ->prefixIcon('heroicon-o-map')
                                        ->helperText('Kode pos wilayah desa'),
                                ]),

                                Textarea::make('alamat_kantor')
                                    ->label('Alamat Kantor Desa')
                                    ->maxLength(500)
                                    ->rows(3)
                                    ->placeholder('Jl. Raya Desa No. 123, Kecamatan ABC, Kabupaten XYZ')
                                    ->helperText('Alamat lengkap kantor desa'),
                            ])
                                ->columnSpan(2),
                        ]),
                    ]),

                Section::make('🎯 Visi & Misi Desa')
                    ->description('Visi dan misi pembangunan desa')
                    ->icon('heroicon-o-eye')
                    ->collapsed(true)
                    ->collapsible(true)
                    ->schema([
                        Grid::make(2)->schema([
                            Card::make()
                                ->schema([
                                    Textarea::make('visi')
                                        ->label('Visi Desa')
                                        ->rows(5)
                                        ->maxLength(1000)
                                        ->placeholder('Masukkan visi desa...')
                                        ->helperText('Tulis visi desa dalam bentuk paragraf atau gunakan enter untuk poin-poin terpisah')
                                        ->columnSpanFull()
                                ])
                                ->columnSpan(1),

                            Card::make()
                                ->schema([
                                    Repeater::make('misi')
                                        ->label('Misi Desa')
                                        ->schema([
                                            TextInput::make('poin_misi')
                                                ->label('Poin Misi')
                                                ->maxLength(500)
                                                ->placeholder('Masukkan poin misi desa')
                                                ->columnSpanFull()
                                        ])
                                        ->addActionLabel('+ Tambah Misi')
                                        ->reorderableWithButtons()
                                        ->collapsible()
                                        ->cloneable()
                                        ->deleteAction(
                                            fn($action) => $action->requiresConfirmation()
                                        )
                                        ->defaultItems(1)
                                        ->itemLabel(fn(array $state): ?string => $state['poin_misi'] ?? 'Misi Baru')
                                ])
                                ->columnSpan(1),
                        ]),
                    ]),

                Section::make('📝 Konten & Informasi Desa')
                    ->description('Informasi detail tentang desa')
                    ->icon('heroicon-o-document-text')
                    ->collapsed(true)
                    ->collapsible(true)
                    ->schema([
                        RichEditor::make('sambutan_kepala_desa')
                            ->label('Sambutan Kepala Desa')
                            ->toolbarButtons([])
                            ->placeholder('Tulis sambutan dari kepala desa...')
                            ->helperText('Sambutan resmi dari kepala desa untuk website'),

                        TextInput::make('motto_desa')
                            ->label('Motto Desa')
                            ->maxLength(255)
                            ->placeholder('Contoh: Bersatu Membangun Desa')
                            ->prefixIcon('heroicon-o-star')
                            ->helperText('Motto atau tagline desa'),

                        FileUpload::make('image_sejarah')
                            ->directory('image_sejarah_desa')
                            ->label('Foto Sejarah')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->image()
                            ->imageEditor()
                            ->maxSize(1024)
                            ->helperText('Max 1MB. Recommended size: 1040px'),

                        RichEditor::make('sejarah_desa')
                            ->label('Sejarah Desa')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'link',
                                'blockquote',
                                'codeBlock'
                            ])
                            ->placeholder('Ceritakan sejarah pembentukan dan perkembangan desa...')
                            ->helperText('Sejarah singkat tentang desa'),

                        RichEditor::make('program_unggulan')
                            ->label('Program Unggulan Desa')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'link',
                                'blockquote',
                                'codeBlock'
                            ])
                            ->placeholder('Deskripsikan program-program unggulan desa...')
                            ->helperText('Program-program prioritas dan unggulan desa'),
                    ]),

                Section::make('📱 Media Sosial Desa')
                    ->description('Akun media sosial resmi desa')
                    ->icon('heroicon-o-share')
                    ->collapsed(true)
                    ->collapsible(true)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('instagram')
                                ->label('Instagram')
                                ->prefix('https://instagram.com/')
                                ->default(str_replace('https://instagram.com/', '', $socialMediaData['instagram'] ?? ''))
                                ->maxLength(255)
                                ->placeholder('username_desa')
                                ->prefixIcon('heroicon-o-camera')
                                ->helperText('Username Instagram tanpa @'),

                            TextInput::make('facebook')
                                ->label('Facebook')
                                ->prefix('https://facebook.com/')
                                ->default(str_replace('https://facebook.com/', '', $socialMediaData['facebook'] ?? ''))
                                ->maxLength(255)
                                ->placeholder('halaman-desa')
                                ->prefixIcon('heroicon-o-users')
                                ->helperText('Nama halaman Facebook'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('tiktok')
                                ->label('TikTok')
                                ->prefix('https://tiktok.com/@')
                                ->default(str_replace('https://tiktok.com/@', '', $socialMediaData['tiktok'] ?? ''))
                                ->maxLength(255)
                                ->placeholder('username_desa')
                                ->prefixIcon('heroicon-o-musical-note')
                                ->helperText('Username TikTok tanpa @'),

                            TextInput::make('youtube')
                                ->label('YouTube')
                                ->prefix('https://youtube.com/')
                                ->default(str_replace('https://youtube.com/', '', $socialMediaData['youtube'] ?? ''))
                                ->maxLength(255)
                                ->placeholder('channel/nama-channel')
                                ->prefixIcon('heroicon-o-video-camera')
                                ->helperText('Channel YouTube'),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('whatsapp')
                                ->label('WhatsApp')
                                ->prefix('https://wa.me/')
                                ->default(str_replace('https://wa.me/', '', $socialMediaData['whatsapp'] ?? ''))
                                ->maxLength(255)
                                ->placeholder('628123456789')
                                ->prefixIcon('heroicon-o-chat-bubble-left-right')
                                ->helperText('Nomor WhatsApp dengan kode negara'),

                            TextInput::make('threads')
                                ->label('Threads')
                                ->prefix('https://threads.net/@')
                                ->default(str_replace(['https://threads.net/@', 'https://threeads.com/'], '', $socialMediaData['threads'] ?? $socialMediaData['threeads'] ?? ''))
                                ->maxLength(255)
                                ->placeholder('username_desa')
                                ->prefixIcon('heroicon-o-at-symbol')
                                ->helperText('Username Threads tanpa @'),
                        ]),
                    ])
                    ->columns(1)
                    ->compact(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo_desa')
                    ->label('Logo')
                    ->circular()
                    ->size(60),

                TextColumn::make('name')
                    ->label('Nama Desa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-envelope'),

                TextColumn::make('no_tlp')
                    ->label('Telepon')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone'),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
            ])
            ->searchable(false)
            ->paginated(false)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil'),
            ])
            ->emptyStateHeading('Belum Ada Profile Desa')
            ->emptyStateDescription('Silakan buat profile desa untuk memulai.')
            ->emptyStateIcon('heroicon-o-building-office-2');
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
            'index' => Pages\ListProfileDesas::route('/'),
            'create' => Pages\CreateProfileDesa::route('/create'),
            'edit' => Pages\EditProfileDesa::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return ProfileDesa::count() === 0;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
