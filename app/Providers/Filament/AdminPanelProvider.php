<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard as PagesDashboard;
use App\Filament\Pages\Profile;
use App\Filament\Resources\CommentResource;
use App\Helpers\ProfileDesa;
use App\Http\Middleware\CheckAdminRole;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->brandName('PANEL ADMIN')
            ->sidebarCollapsibleOnDesktop()
            ->databaseNotifications()
            ->databaseNotificationsPolling('10s')
            ->globalSearch(false)
            ->userMenuItems([
                'logout' => MenuItem::make()->label('Log Out'),
                'profile' => MenuItem::make()
                    ->label('Profile')
                    ->url(fn(): string => Profile::getUrl())
                    ->icon('heroicon-o-user-circle'),
            ])
            ->favicon(isset(ProfileDesa::GetProfileDesa()->logo_desa) ? asset('storage/' .  ProfileDesa::GetProfileDesa()->logo_desa) : asset('assets/logo/Logo_Kabupaten_Malang.png'))
            ->default()
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Green,
            ])
            ->pages([
                Profile::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Profile Desa')
                    ->collapsible(false)
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                PagesDashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                CheckAdminRole::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
