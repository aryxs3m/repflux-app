<?php

namespace App\Providers\Filament;

use App\Filament\Pages\EditProfile\EditProfile;
use App\Filament\Pages\LoginPage;
use App\Filament\Pages\RegisterPage;
use App\Filament\Pages\Tenancy\EditTenantProfile;
use App\Filament\Pages\Tenancy\RegisterTenant;
use App\Filament\Resources\TenantResources\UserResource;
use App\Filament\Resources\WeightResource\Widgets\WeightChart;
use App\Filament\Resources\WeightResource\Widgets\WeightStats;
use App\Filament\Resources\WorkoutResource\Widgets\WorkoutCategoryChart;
use App\Filament\Widgets\WorkoutHeatmapChart;
use App\Http\Middlewares\LanguageHandlerMiddleware;
use App\Models\Tenant;
use Blade;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;

class AppPanelProvider extends PanelProvider
{
    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->brandName('Repflux')
            ->brandLogo('/logos/repflux_logo_transparent.png')
            ->darkMode(true, true)
            ->favicon('/logos/favicon.png')
            ->spa()
            ->id('app')
            ->path('app')
            ->login(LoginPage::class)
            ->registration(RegisterPage::class)
            ->passwordReset()
            ->emailVerification()
            ->profile(EditProfile::class)
            ->tenant(Tenant::class)
            ->tenantRegistration(RegisterTenant::class)
            ->tenantProfile(EditTenantProfile::class)
            ->tenantMenuItems([
                Action::make('users')
                    ->label(__('pages.tenancy.users.title'))
                    ->url(fn (): string => UserResource::getUrl())
                    ->icon(Heroicon::UserGroup),
            ])
            ->colors([
                'primary' => Color::generateV3Palette('#ff0000'),
            ])
            ->font('Farro')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                WorkoutHeatmapChart::class,
                WeightStats::class,
                WeightChart::class,
                WorkoutCategoryChart::class,
            ])
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
                LanguageHandlerMiddleware::class,
            ])
            // ->userMenuItems([])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                function (): string {
                    return Blade::render('@laravelPWA');
                }
            )
            ->renderHook(
                PanelsRenderHook::BODY_START,
                function (): string {
                    if (! config('app.demo.enabled')) {
                        return '';
                    }

                    return Blade::render('demo-warning');
                }
            )
            ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_END,
                fn () => Blade::render('version-info'),
            )
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                function (): string {
                    return Blade::render('feedback-button');
                }
            )
            ->plugins([
                FilamentApexChartsPlugin::make(),
                FilamentSocialitePlugin::make()
                    ->rememberLogin(true)
                    ->providers([
                        Provider::make('google')
                            ->label('Google')
                            ->icon('fab-google')
                            ->color(Color::Red)
                            ->stateless(false)
                            ->visible(! empty(config('services.google.client_id'))),
                        Provider::make('discord')
                            ->label('Discord')
                            ->icon('fab-discord')
                            ->color(Color::Indigo)
                            ->stateless(false)
                            ->visible(! empty(config('services.discord.client_id'))),
                        Provider::make('facebook')
                            ->label('Facebook')
                            ->icon('fab-facebook')
                            ->color(Color::Blue)
                            ->stateless(false)
                            ->visible(! empty(config('services.facebook.client_id'))),
                        Provider::make('github')
                            ->label('GitHub')
                            ->icon('fab-github')
                            ->color(Color::Slate)
                            ->stateless(false)
                            ->visible(! empty(config('services.github.client_id'))),
                    ])
                    ->registration(),
            ]);
    }
}
