<p align="center">
    <img src="/public/logos/repflux_logo_black_transparent.png#gh-light-mode-only" width="400"/>
    <img src="/public/logos/repflux_logo_transparent.png#gh-dark-mode-only" width="400"/>
</p>

[![Code Quality](https://github.com/aryxs3m/gymbro/actions/workflows/code-quality.yml/badge.svg)](https://github.com/aryxs3m/gymbro/actions/workflows/code-quality.yml) [![Pest Tests](https://github.com/aryxs3m/repflux-app/actions/workflows/pest.yml/badge.svg)](https://github.com/aryxs3m/repflux-app/actions/workflows/pest.yml) [![Translations Check](https://github.com/aryxs3m/gymbro/actions/workflows/translations.yml/badge.svg)](https://github.com/aryxs3m/gymbro/actions/workflows/translations.yml) [![Discord](https://img.shields.io/discord/1421202193633251561?logo=discord&label=Discord)](https://discord.gg/8DNa7YGkEY) 


A simple fitness tracker app built with Laravel and Filament.

- 🏋🏻 track your sets, reps, and weight for each exercise
- 💪 view your progress over time with charts and graphs
- 📐 save body measurements and track your weight

## 🔥 Quickstart

- **DEMO site**: [demo.repflux.app](https://demo.repflux.app)
- **FREE cloud version** is available at [repflux.app](https://repflux.app)

## 🚀 Features

- [x] workout logging
- [x] body measurements
- [x] weight tracking
- [x] progression widgets/charts/reports
- [x] PR tracking
- [x] PWA
- [x] full dark mode support
- [x] multilingual (English, Hungarian)
- [x] imperial / metric support

## 🖥️ Installation

### Native

Installation for php-fpm + web server:

1. Clone the repository
2. Run `npm install`
3. Run `npm run build`
4. Run `composer install`
5. Copy `.env.example` to `.env`
6. Modify `.env` according to your taste
7. Run `php artisan key:generate`
8. Run `php artisan migrate`
9. Profit!

### Docker Compose

TBD.

## Demo data

You can enable demo mode by adding the following lines to your `.env` file:

```dotenv
APP_DEMO=true
APP_DEMO_EMAIL=demo@repflux.app
APP_DEMO_PASSWORD=YOUR_DEMO_PASSWORD_CAN_BE_ANYTHING
```

Then run the following command:

```sh
php artisan migrate:fresh --seed --seeder=DemoSeeder
```

This will recreate all database tables and create a single user with a tenant and some fake data.
