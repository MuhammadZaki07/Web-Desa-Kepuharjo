<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    public function getTitle(): string
    {
        return 'Edit Admin: ' . $this->record->name;
    }

    public function getHeading(): string
    {
        return 'Edit Admin';
    }

    public function getSubheading(): ?string
    {
        return 'Update admin information and credentials';
    }

    protected function authorizeAccess(): void
    {
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Only super admin can edit admin users.');
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Admin Information')
                ->description('Update admin details and credentials')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('role')
                            ->label('Position')
                            ->options([
                                'super_admin' => 'Super admin',
                                'admin' => 'Admin',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->helperText('Leave blank to keep current password'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active Status')
                            ->helperText('Deactivating will convert user back to resident'),
                    ]),
                ])
                ->collapsible()
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Delete Admin')
                ->modalDescription('Are you sure you want to delete this admin? This action cannot be undone.')
                ->visible(fn () => Auth::user()->role === 'super_admin'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!$data['is_active']) {
            $data['role'] = 'penduduk';
        } else {
            $data['role'] = 'admin';
        }

        return $data;
    }
}
