# Star Wars

## App structure

This project uses Laravel 12’s streamlined structure. Here’s a quick map of the key directories and what they do:

```
.
├─ app/
│  ├─ StarWars/                 # Domain: SW API integration (Actions, Commands, Contracts, Adapters, Dtos)
│  ├─ Stats/                    # Domain: Analytics & stats (Actions, Commands, Contracts, Events, LoggerAnalytics, Middleware)
│  ├─ Movies/                   # Domain: Movies (Controllers, Models, Requests, Actions, Dto)
│  ├─ People/                   # Domain: People (Controllers, Models, Requests, Actions, Dto)
│  ├─ Http/                     # Controllers & Form Requests (shared)
│  └─ Support/                  # Shared helpers (RouteName, TimeTracker, Http)
├─ bootstrap/
│  ├─ app.php                   # Routing, middleware, exceptions
│  └─ providers.php             # Application-specific service providers
├─ routes/                      # Routes (api.php, web.php, console.php)
├─ database/                    # Migrations, factories, seeders
├─ resources/                   # Frontend resources (css, js, views)
├─ public/                      # Public assets and index.php
├─ config/                      # Configuration files
├─ tests/                       # Pest tests (Feature, Unit)
```

Conventions:
- Actions encapsulate business logic (no console/UI); commands handle console IO and delegate to Actions.
- Commands are auto-discovered by Laravel 12; module commands under `app/*/Commands` are available without manual registration.
- Scheduled tasks live in `routes/console.php`.
- Prefer Eloquent models and relationships; avoid raw queries when possible.
- Keep formatting consistent with Pint: `vendor/bin/pint --dirty`.

## Start the server

Prerequisites:
- PHP 8.4+
- Composer
- Node.js and npm

Quick start (recommended):

```zsh
# From the project root
composer run setup   # installs deps, creates .env, generates key, runs migrations, installs npm deps, builds assets
composer run dev     # runs: PHP server, queue listener, logs, Vite dev server, and scheduler
```

- The API will be available via the PHP development server (default http://127.0.0.1:8000).
- Stop all processes with Ctrl+C.

Minimal alternative:

```zsh
# If you only need the API without the extra dev processes
composer install
cp .env.example .env || true
php artisan key:generate
php artisan migrate --force
npm install
php artisan serve
# In another terminal, if you need assets recompiled on change
npm run dev
```

Troubleshooting:
- Vite manifest error (Unable to locate file in Vite manifest): run `npm run dev` or `npm run build`.
- Frontend changes not visible: make sure `npm run dev` (or `npm run build`) is running.
