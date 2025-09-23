[![Code Quality](https://github.com/aryxs3m/gymbro/actions/workflows/code-quality.yml/badge.svg)](https://github.com/aryxs3m/gymbro/actions/workflows/code-quality.yml) [![Laravel test](https://github.com/aryxs3m/gymbro/actions/workflows/laravel.yml/badge.svg)](https://github.com/aryxs3m/gymbro/actions/workflows/laravel.yml) [![Translations Check](https://github.com/aryxs3m/gymbro/actions/workflows/translations.yml/badge.svg)](https://github.com/aryxs3m/gymbro/actions/workflows/translations.yml)

<img src="/public/logos/repflux_logo_transparent.png" alt="drawing" width="200"/>

A simple fitness tracker app built with Laravel and Filament.

- 🏋🏻 track your sets, reps, and weight for each exercise
- 💪 view your progress over time with charts and graphs
- 📐 save body measurements and track your weight

## 🚀 Features

- [x] PWA
- [x] full dark mode support
- [x] multilingual (English, Hungarian)
- [x] imperial / metric support

## 🖥️ Installation

### Native

Installation for php-fpm + web server:

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env`
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed`
6. Profit!

## Docker Compose

TBD.

## Demo data

After installation enable the demo mode and set up the demo credentials in the .env file:

```dotenv
APP_DEMO=true
APP_DEMO_EMAIL=demo@repflux.app
APP_DEMO_PASSWORD=Repflux12345678
```

Then run the following command:

```sh
php artisan migrate:fresh --seed --seeder=DemoSeeder
```

This will recreate all database tables and create a single user with a tenant and some fake data.
