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
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class BannerResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Spanduk (Banners)';

    protected static ?string $model = Banner::class;

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
                    ->label(fn($record) => $record?->type === 'sejarah' ? 'Upload 5 Gambar Sejarah (Wajib)' : 'Upload Gambar')
                    ->directory('banners')
                    ->multiple(fn($record) => $record?->type === 'sejarah')
                    ->reorderable(fn($record) => $record?->type === 'sejarah')
                    ->appendFiles(fn($record) => $record?->type === 'sejarah')
                    ->maxFiles(fn($record) => $record?->type === 'sejarah' ? 5 : 1)
                    ->minFiles(fn($record) => $record?->type === 'sejarah' ? 5 : 1)
                    ->maxWidth(1440)
                    ->imagePreviewHeight('250')
                    ->required()
                    ->hint(
                        fn($record) =>
                        $record?->type === 'sejarah'
                            ? new HtmlString('<span class="text-red-500">Wajib upload tepat 5 gambar</span>')
                            : null
                    )
                    ->columnSpan(2),

                Repeater::make('title_sejarah')
                    ->label('Judul Gambar')
                    ->visible(fn($record) => $record?->type === 'sejarah')
                    ->minItems(5)
                    ->maxItems(5)
                    ->columns(1)
                    ->deletable(false)
                    ->schema([
                        TextInput::make('value')->label('Judul Gambar')->required(),
                    ])
                    ->columnSpan(2)
                    ->afterStateHydrated(function ($component, $state) {
                        if (is_array($state) && !empty($state) && is_string($state[0])) {
                            $newState = array_map(fn($item) => ['value' => $item], $state);
                            $component->state($newState);
                        }
                    }),


                TextInput::make('title')
                    ->label('Judul Banner')
                    ->required()
                    ->visible(fn($record) => $record?->type !== 'sejarah')
                    ->formatStateUsing(fn($state) => is_array($state) ? ($state[0] ?? '') : $state)
                    ->afterStateHydrated(fn($component, $state) => $component->state(
                        is_array($state) ? ($state[0] ?? '') : $state
                    ))
                    ->dehydrateStateUsing(fn($state) => [$state]),



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
                    ->stacked()
                    ->circular()
                    ->limit(1)
                    ->limitedRemainingText()
                    ->width(100)
                    ->url(function ($record) {
                        $images = $record->images;
                        if (is_array($images)) {
                            return isset($images[0]) ? Storage::url($images[0]) : asset('assets/banners/preview-1.png');
                        }
                        return $images ? Storage::url($images) : asset('assets/banners/preview-1.png');
                    })
                    ->defaultImageUrl(asset('assets/banners/preview-1.png')),

                TextColumn::make('formatted_title')->label('Judul')->limit(50),

                TextColumn::make('type')
                    ->badge()
                    ->color('info'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make()
                    ->using(function (Banner $record, array $data): Banner {
                        if ($record->type === 'sejarah') {
                            if (!isset($data['title_sejarah']) || !is_array($data['title_sejarah'])) {
                                throw new \Exception('Judul sejarah harus berupa array.');
                            }
                            $title_sejarah = $data['title_sejarah'];
                            $title = $record->title ?? [];
                        } else {
                            if (!isset($data['title']) || !is_array($data['title'])) {
                                throw new \Exception('Judul harus berupa array.');
                            }
                            $title = $data['title'];
                            $title_sejarah = null;
                        }

                        if (!is_array($data['images'])) {
                            $data['images'] = [$data['images']];
                        }

                        $record->update([
                            'title' => $title,
                            'title_sejarah' => $title_sejarah,
                            'images' => $data['images'],
                        ]);

                        return $record;
                    }),

            ])
            ->paginated(false)
            ->bulkActions([]);
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
            'index' => Pages\ListBanners::route('/'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
