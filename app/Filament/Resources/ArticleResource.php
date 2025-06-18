<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Berita';
    protected static ?string $navigationGroup = "Konten";

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Article Content')
                    ->description('Create and manage your blog articles')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $context, $state, Forms\Set $set) {
                                        if ($context === 'create') {
                                            $set('slug', Str::slug($state));
                                        }
                                    })
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Article::class, 'slug', ignoreRecord: true)
                                    ->alphaDash()
                                    ->helperText('URL-friendly version')
                                    ->columnSpan(1),
                            ]),

                        Forms\Components\Textarea::make('excerpt')
                            ->rows(3)
                            ->maxLength(300)
                            ->helperText('Brief summary of the article (will be auto-generated from content if empty)'),

                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('articles/attachments')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Section::make('Article Settings')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn(Builder $query) => $query->where('type', 'blogs')
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (string $context, $state, Forms\Set $set) {
                                        if ($context === 'create') {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                Forms\Components\Hidden::make('type')
                                    ->default('blogs'),

                                Forms\Components\ColorPicker::make('color')
                                    ->default('#3B82F6'),
                            ])
                            ->createOptionModalHeading('Create New Blog Category'),

                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required()
                            ->native(false)
                            ->live(),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->visible(fn(Forms\Get $get): bool => $get('status') === 'published')
                            ->default(now())
                            ->required(fn(Forms\Get $get): bool => $get('status') === 'published'),

                        Forms\Components\FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory('articles/images')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(1024)
                            ->helperText('Max size: 1MB. Recommended ratio: 16:9'),


                        Forms\Components\Hidden::make('user_id')
                            ->default(Auth::user()->id),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->disk('public')
                    ->size(60)
                    ->circular(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->wrap()
                    ->limit(30), // Batasi 30 karakter, tambahkan elipsis (...)

                TextColumn::make('category.name')
                    ->badge()
                    ->color(fn(Article $record): string => match ($record->category?->type) {
                        'blogs' => 'primary',
                        'umkm' => 'success',
                        'wisata' => 'warning',
                        default => 'gray',
                    }),

                BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'warning' => 'archived',
                    ])
                    ->icons([
                        'heroicon-o-pencil-square' => 'draft',
                        'heroicon-o-eye' => 'published',
                        'heroicon-o-archive-box' => 'archived',
                    ]),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('viewers')
                    ->label('Views')
                    ->badge()
                    ->color('gray')
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordUrl(null)
            ->recordAction(null)
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ])
                    ->multiple(),

                SelectFilter::make('category')
                    ->relationship('category', 'name', fn(Builder $query) => $query->where('type', 'blogs'))
                    ->searchable()
                    ->preload(),

                Filter::make('published_at')
                    ->form([
                        Forms\Components\DatePicker::make('published_from')
                            ->label('Published from'),
                        Forms\Components\DatePicker::make('published_until')
                            ->label('Published until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
            ])
            ->actions(
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view')
                        ->label('View')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Article $record): string => route('articles.show', $record->slug))
                        ->openUrlInNewTab(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('toggleStatus')
                        ->label(fn(Article $record): string => match ($record->status) {
                            'draft' => 'Publish',
                            'published' => 'Unpublish',
                            'archived' => 'Restore',
                            default => 'Update',
                        })
                        ->icon(fn(Article $record): string => match ($record->status) {
                            'draft' => 'heroicon-o-eye',
                            'published' => 'heroicon-o-eye-slash',
                            'archived' => 'heroicon-o-arrow-uturn-left',
                            default => 'heroicon-o-arrow-path',
                        })
                        ->color(fn(Article $record): string => match ($record->status) {
                            'draft' => 'success',
                            'published' => 'warning',
                            'archived' => 'info',
                            default => 'gray',
                        })
                        ->action(function (Article $record): void {
                            match ($record->status) {
                                'draft' => $record->update([
                                    'status' => 'published',
                                    'published_at' => now(),
                                ]),
                                'published' => $record->update(['status' => 'draft']),
                                'archived' => $record->update(['status' => 'draft']),
                            };
                        })
                        ->requiresConfirmation(),
                    Tables\Actions\DeleteAction::make()
                        ->requiresConfirmation(),
                ])
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->color('gray')
            )
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Publish Selected')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'published',
                                    'published_at' => $record->published_at ?? now(),
                                ]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Publish Articles')
                        ->modalDescription('Are you sure you want to publish the selected articles?'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('No articles found')
            ->emptyStateDescription('Start writing your first blog article.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create Article')
                    ->icon('heroicon-o-plus'),
            ]);
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'published')->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category', 'author']);
    }
}
