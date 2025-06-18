<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;

class AdminResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = "User Management";
    protected static ?string $navigationLabel = 'Admin Management';
    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        return Auth::check() && in_array(Auth::user()->jabatan, ['super_admin', 'admin_desa']);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::check() && in_array(Auth::user()->jabatan, ['super_admin', 'admin_desa']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Admin Creation')
                ->description('Select residents to promote to admin role')
                ->icon('heroicon-o-user-plus')
                ->schema([
                    Forms\Components\Select::make('penduduk_ids')
                        ->label('Select Residents')
                        ->helperText('Choose one or more residents to promote to admin')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->options(function () {
                            return \App\Models\Penduduk::whereHas(
                                'user',
                                fn($q) =>
                                $q->where('role', 'penduduk')
                            )
                                ->with('user')
                                ->get()
                                ->mapWithKeys(fn($p) => [
                                    $p->user->id => "{$p->user->name} (NIK: {$p->nik})"
                                ])
                                ->toArray();
                        })
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if (empty($state)) {
                                $set('admin_details', []);
                                return;
                            }

                            $penduduks = \App\Models\Penduduk::whereHas(
                                'user',
                                fn($q) =>
                                $q->where('role', 'penduduk')
                            )
                                ->whereIn('user_id', (array) $state)
                                ->with('user')
                                ->get();

                            $details = $penduduks->map(function ($p) {
                                return [
                                    'user_id' => $p->user->id,
                                    'name' => $p->user->name,
                                    'nik' => $p->nik,
                                    'alamat' => $p->alamat,
                                    'email' => $p->user->email ?? '',
                                    'password' => '',
                                ];
                            })->toArray();

                            $set('admin_details', $details);
                        }),

                    Forms\Components\Repeater::make('admin_details')
                        ->label('Admin Details')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('name')
                                        ->label('Full Name')
                                        ->disabled()
                                        ->dehydrated(false),
                                    Forms\Components\TextInput::make('nik')
                                        ->label('NIK')
                                        ->disabled()
                                        ->dehydrated(false),
                                    Forms\Components\TextInput::make('alamat')
                                        ->label('Address')
                                        ->disabled()
                                        ->columnSpanFull()
                                        ->dehydrated(false),
                                    Forms\Components\TextInput::make('email')
                                        ->label('Email Address')
                                        ->email()
                                        ->required()
                                        ->unique('users', 'email')
                                        ->placeholder('Enter admin email'),
                                    Forms\Components\TextInput::make('password')
                                        ->label('Password')
                                        ->password()
                                        ->required()
                                        ->minLength(8)
                                        ->placeholder('Minimum 8 characters'),
                                    Forms\Components\Hidden::make('user_id'),
                                ])
                        ])
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->visible(fn($get) => !empty($get('penduduk_ids')))
                        ->columns(1)
                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),
                ])
                ->collapsible()
                ->persistCollapsed()
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::where('role', 'admin')->with(['penduduk']))
            ->columns([
                TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-m-user'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-identification'),

                TextColumn::make('jabatan')
                    ->label('Position')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin' => 'success',
                        'admin_desa' => 'warning',
                        default => 'gray',
                    }),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->placeholder('All Status'),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make()
                        ->visible(fn() => Auth::user()->jabatan === 'super_admin')
                        ->color('warning')
                        ->icon('heroicon-m-pencil-square'),

                    Action::make('toggle_status')
                        ->label(fn($record) => $record->is_active ? 'Deactivate' : 'Activate')
                        ->action(function ($record) {
                            $record->update([
                                'is_active' => !$record->is_active,
                                'jabatan' => $record->is_active ? 'penduduk' : 'admin',
                            ]);
                        })
                        ->visible(fn() => Auth::user()->jabatan === 'super_admin')
                        ->requiresConfirmation()
                        ->modalHeading(fn($record) => ($record->is_active ? 'Deactivate' : 'Activate') . ' Admin')
                        ->modalDescription(fn($record) => $record->is_active
                            ? 'This will deactivate the admin and convert them back to resident status.'
                            : 'This will activate the admin and restore their admin privileges.')
                        ->color(fn($record) => $record->is_active ? 'danger' : 'success')
                        ->icon(fn($record) => $record->is_active ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle'),

                    DeleteAction::make()
                        ->visible(fn() => Auth::user()->jabatan === 'super_admin')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Admin')
                        ->modalDescription('Are you sure you want to delete this admin? This action cannot be undone.')
                        ->color('danger')
                        ->icon('heroicon-m-trash'),
                ])
                    ->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->button(),
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->visible(fn() => Auth::user()->jabatan === 'super_admin')
                    ->requiresConfirmation()
                    ->modalHeading('Delete Selected Admins')
                    ->modalDescription('Are you sure you want to delete the selected admins? This action cannot be undone.'),
            ])
            ->emptyStateHeading('No Admins Found')
            ->emptyStateDescription('No admin users have been created yet.')
            ->emptyStateIcon('heroicon-o-shield-exclamation')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [];
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
        return Cache::remember('active_admin_count', 300, function () {
            return User::where('jabatan', 'admin')
                ->where('is_active', true)
                ->count();
        });
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'admin');
    }
}
