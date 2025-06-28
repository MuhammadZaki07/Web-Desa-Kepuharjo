<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;

class Profile extends Page implements HasForms, HasActions
{
    use InteractsWithForms, InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $title = 'Profile Settings';
    protected static string $view = 'filament.pages.profile';
    protected static ?int $navigationSort = 999;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->profileForm->fill([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'photo' => $user->photo,
        ]);

        $this->passwordForm->fill();
    }

    public function profileForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profile Information')
                    ->description('Update your account profile information')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                FileUpload::make('photo')
                                    ->label('Profile Photo')
                                    ->image()
                                    ->avatar()
                                    ->imageEditor()
                                    ->circleCropper()
                                    ->directory('profile-photos')
                                    ->visibility('private')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                                    ->maxSize(2048)
                                    ->helperText('Upload a profile photo (max 2MB)')
                                    ->columnSpanFull(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Full Name')
                                    ->required()
                                    ->disabled()
                                    ->helperText('Contact administrator to change your name')
                                    ->columnSpan(2),

                                TextInput::make('email')
                                    ->label('Email Address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->columnSpan(1),

                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(15)
                                    ->helperText('Enter your phone number with country code')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columns(1),
            ])
            ->statePath('profileData')
            ->model(Auth::user());
    }

    public function passwordForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Change Password')
                    ->description('Update your password to keep your account secure')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                TextInput::make('current_password')
                                    ->label('Current Password')
                                    ->password()
                                    ->required()
                                    ->currentPassword()
                                    ->revealable()
                                    ->columnSpanFull(),

                                TextInput::make('password')
                                    ->label('New Password')
                                    ->password()
                                    ->required()
                                    ->rule(Password::default())
                                    ->revealable()
                                    ->same('password_confirmation')
                                    ->helperText('Password must be at least 8 characters long')
                                    ->columnSpanFull(),

                                TextInput::make('password_confirmation')
                                    ->label('Confirm New Password')
                                    ->password()
                                    ->required()
                                    ->revealable()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columns(1),
            ])
            ->statePath('passwordData');
    }

    public function updateProfile(): void
    {
        $data = $this->profileForm->getState();
        $user = Auth::user();

        $user->update([
            'email' => $data['email'],
            'phone' => $data['phone'],
            'photo' => $data['photo'] ?? $user->photo,
        ]);

        Notification::make()
            ->title('Profile Updated')
            ->body('Your profile has been updated successfully.')
            ->success()
            ->send();
    }

    public function updatePassword(): void
    {
        $data = $this->passwordForm->getState();
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        $this->passwordForm->fill();

        Notification::make()
            ->title('Password Updated')
            ->body('Your password has been changed successfully.')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('updateProfile')
                ->label('Update Profile')
                ->color('primary')
                ->icon('heroicon-o-check')
                ->action('updateProfile'),

            Action::make('updatePassword')
                ->label('Change Password')
                ->color('warning')
                ->icon('heroicon-o-key')
                ->action('updatePassword'),
        ];
    }

    public function getForms(): array
    {
        return [
            'profileForm',
            'passwordForm',
        ];
    }
}
