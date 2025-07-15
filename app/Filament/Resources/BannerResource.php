<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class BannerResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Spanduk (Banners)';

    protected static ?string $model = Banner::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select(['id', 'title', 'title_sejarah', 'images', 'type', 'description'])
            ->orderBy('id');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                FileUpload::make('images')
                    ->image()
                    ->dehydrated(true)
                    ->label(fn($record) => $record?->type === 'sejarah' ? 'Upload 5 Gambar Sejarah (Wajib)' : 'Upload Gambar')
                    ->directory('banners')
                    ->reorderable(fn($record) => $record?->type === 'sejarah')
                    ->appendFiles(fn($record) => $record?->type === 'sejarah')
                    ->multiple(fn(Get $get) => $get('type') === 'sejarah')
                    ->maxFiles(fn(Get $get) => $get('type') === 'sejarah' ? 5 : 1)
                    // HAPUS minFiles - ini yang menyebabkan masalah!
                    // ->minFiles(fn(Get $get) => $get('type') === 'sejarah' ? 5 : 1)
                    ->maxWidth(1440)
                    ->imagePreviewHeight('250')
                    ->required()
                    ->imageEditor(fn($record) => $record?->type !== 'sejarah')
                    ->hint(
                        fn($record) =>
                        $record?->type === 'sejarah'
                            ? new HtmlString('<span class="text-red-500">Wajib upload tepat 5 gambar</span>')
                            : null
                    )
                    ->helperText(fn($record) => $record?->type === "sejarah" ? "Geser gambar untuk atur urutan tampil" : "")
                    ->columnSpan(2)
                    // Custom validation rules untuk menggantikan minFiles
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                // Ambil record dari context
                                $record = request()->route('record');
                                if ($record && $record->type === 'sejarah') {
                                    if (!is_array($value) || count($value) !== 5) {
                                        $fail('Untuk banner sejarah, wajib upload tepat 5 gambar.');
                                    }
                                }
                            };
                        }
                    ]),

                Repeater::make('title_sejarah')
                    ->label('Judul Gambar')
                    ->visible(fn($record) => $record?->type === 'sejarah')
                    ->minItems(5)
                    ->reorderable(false)
                    ->maxItems(5)
                    ->columns(1)
                    ->deletable(false)
                    ->addable(false)
                    ->schema([
                        TextInput::make('value')
                            ->label('Judul Gambar')
                            ->required(),
                    ])
                    ->columnSpan(2)
                    ->default(function () {
                        return array_fill(0, 5, ['value' => '']);
                    })
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if (!$state || !is_array($state)) {
                            $component->state(array_fill(0, 5, ['value' => '']));
                            return;
                        }
                        if (isset($state[0]) && is_string($state[0])) {
                            $newState = [];
                            for ($i = 0; $i < 5; $i++) {
                                $newState[] = ['value' => $state[$i] ?? ''];
                            }
                            $component->state($newState);
                            return;
                        }

                        $newState = [];
                        for ($i = 0; $i < 5; $i++) {
                            $newState[] = [
                                'value' => isset($state[$i]['value']) ? (string) $state[$i]['value'] : ''
                            ];
                        }
                        $component->state($newState);
                    })
                    ->mutateDehydratedStateUsing(function ($state) {
                        if (!is_array($state)) {
                            return array_fill(0, 5, '');
                        }

                        $result = [];
                        foreach ($state as $item) {
                            if (is_array($item) && isset($item['value'])) {
                                $result[] = (string) $item['value'];
                            } elseif (is_string($item)) {
                                $result[] = $item;
                            } else {
                                $result[] = '';
                            }
                        }

                        while (count($result) < 5) {
                            $result[] = '';
                        }

                        return array_slice($result, 0, 5);
                    }),

                TextInput::make('title')
                    ->label('Judul Banner')
                    ->required()
                    ->visible(fn($record) => $record?->type !== 'sejarah')
                    ->afterStateHydrated(function ($component, $state) {
                        if (is_array($state)) {
                            $component->state($state[0] ?? '');
                        } elseif (!is_string($state)) {
                            $component->state('');
                        } else {
                            $component->state($state);
                        }
                    })
                    ->mutateDehydratedStateUsing(function ($state) {
                        return [(string) $state];
                    }),

                TextInput::make('type')->readOnly(),
                Textarea::make('description')
                    ->visible(fn($record) => $record?->type !== 'sejarah')
                    ->required()
                    ->columnSpan(2),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label('Gambar')
                    ->circular()
                    ->size(50)
                    ->getStateUsing(function ($record) {
                        $images = $record->images;
                        return is_array($images) && !empty($images) ? $images[0] : $images;
                    })
                    ->defaultImageUrl(asset('assets/banners/preview-1.png'))
                    ->checkFileExistence(false),

                TextColumn::make('formatted_title')
                    ->label('Judul')
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->formatted_title;
                    }),

                TextColumn::make('type')
                    ->badge()
                    ->color('info'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->using(function (Banner $record, array $data): Banner {
                        $updateData = [];

                        if ($record->type === 'sejarah') {
                            // Handle title_sejarah
                            if (isset($data['title_sejarah']) && is_array($data['title_sejarah'])) {
                                $titles = [];
                                foreach ($data['title_sejarah'] as $item) {
                                    if (is_array($item) && isset($item['value'])) {
                                        $titles[] = (string) $item['value'];
                                    } elseif (is_string($item)) {
                                        $titles[] = $item;
                                    } else {
                                        $titles[] = '';
                                    }
                                }
                                $updateData['title_sejarah'] = $titles;
                            }
                        } else {
                            // Handle regular title
                            $updateData['title'] = is_array($data['title'])
                                ? [(string) ($data['title'][0] ?? '')]
                                : [(string) ($data['title'] ?? '')];
                        }

                        if (isset($data['images'])) {
                            $updateData['images'] = is_array($data['images'])
                                ? $data['images']
                                : [(string) $data['images']];
                        }

                        if (isset($data['description'])) {
                            $updateData['description'] = (string) $data['description'];
                        }

                        $record->update($updateData);
                        return $record;
                    }),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(10)
            ->bulkActions([]);
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
