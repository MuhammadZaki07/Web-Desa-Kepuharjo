<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileDesaResource\Pages;
use App\Models\ProfileDesa;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;

class ProfileDesaResource extends Resource
{
    protected static ?string $model = ProfileDesa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Profile';

    public static function form(Form $form): Form
    {
        $data = DB::table('sosial_media')->pluck('url', 'platform')->toArray();
        return $form
            ->schema([
                Section::make('Identitas Desa')
                    ->description('Informasi dasar tentang desa')
                    ->collapsed(false)
                    ->collapsible(false)
                    ->schema([
                        Grid::make(3)->schema([
                            FileUpload::make('logo_desa')
                                ->label('Logo Desa')
                                ->image()
                                ->directory('desa-logos')
                                ->maxSize(1024)
                                ->imagePreviewHeight('100')
                                ->imageResizeTargetWidth('100')
                                ->imageResizeTargetHeight('100')
                                ->imageCropAspectRatio('1:1')
                                ->panelLayout('compact')
                                ->panelAspectRatio('1:1')
                                ->uploadButtonPosition('bottom')
                                ->openable()
                                ->required()
                                ->columnSpan(1),

                            Grid::make(1)->schema([
                                TextInput::make('name')
                                    ->label('Nama Desa')
                                    ->required()
                                    ->maxLength(255),

                                Grid::make(2)->schema([
                                    TextInput::make('email')
                                        ->label('Email Resmi')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('no_tlp')
                                        ->label('No. Telepon Desa')
                                        ->tel()
                                        ->required()
                                        ->maxLength(20),
                                ]),

                                Section::make('Media Sosial')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('instagram')
                                                ->label('Instagram')
                                                ->prefix('https://instagram.com/')
                                                ->default(str_replace('https://instagram.com/', '', $data['instagram'] ?? ''))
                                                ->maxLength(255),

                                            TextInput::make('facebook')
                                                ->label('Facebook')
                                                ->prefix('https://facebook.com/')
                                                ->default(str_replace('https://facebook.com/', '', $data['facebook'] ?? ''))
                                                ->maxLength(255)
                                        ]),
                                        Grid::make(2)->schema([
                                            TextInput::make('tiktok')
                                                ->label('TikTok')
                                                ->prefix('https://tiktok.com/@')
                                                ->default(str_replace('https://tiktok.com/@', '', $data['tiktok'] ?? ''))
                                                ->maxLength(255),
                                            TextInput::make('youtube')
                                                ->label('YouTube')
                                                ->prefix('https://youtube.com/')
                                                ->default(str_replace('https://youtube.com/', '', $data['youtube'] ?? ''))
                                                ->maxLength(255)
                                        ]),
                                        Grid::make(2)->schema([
                                            TextInput::make('whatsapp')
                                                ->label('WhatsApp')
                                                ->prefix('https://wa.me/')
                                                ->default(str_replace('https://wa.me/', '', $data['whatsapp'] ?? ''))
                                                ->maxLength(255),
                                            TextInput::make('threeads')
                                                ->label('Threeads')
                                                ->prefix('https://threeads.com/')
                                                ->default(str_replace('https://threeads.com/', '', $data['threeads'] ?? ''))
                                                ->maxLength(255)
                                        ]),
                                    ])
                                    ->columns(1)
                                    ->collapsible()
                                    ->compact(),
                            ])
                                ->columnSpan(2),
                        ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\RedirectToEditProfileDesa::route('/'),
            'edit' => Pages\EditProfileDesa::route('/{record}/edit'),
        ];
    }
}
