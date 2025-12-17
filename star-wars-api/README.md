# Star Wars API

A Laravel 12 API for searching and retrieving Star Wars movies and people data, with built-in analytics tracking.

## Features

- **SWAPI Integration**: Sync and cache Star Wars data from the official SWAPI
- **Movies API**: Search movies by title, get movie details
- **People API**: Search people by name, get person details
- **Analytics Dashboard**: Track query statistics, request times, and usage patterns
- **Event-driven Stats**: Automatic logging via middleware and events
- **Domain-driven Structure**: Organized by domain modules (Movies, People, Stats, StarWars)

## Tech Stack

- **Framework**: Laravel 12 with streamlined structure
- **PHP**: 8.4+
- **Database**: MySQL 8.0
- **Testing**: Pest PHP
- **Code Quality**: Laravel Pint

## App Structure

This project uses Laravel 12's streamlined structure with domain-driven organization:

```
.
├─ app/
│  ├─ StarWars/                 # Domain: SW API integration
│  │  ├─ Actions/               # Business logic for SWAPI operations
│  │  ├─ Adapters/              # HTTP client adapters for SWAPI
│  │  ├─ Commands/              # Artisan commands (sync:people, sync:films, sync)
│  │  ├─ Contracts/             # Interfaces for SWAPI client
│  │  ├─ Dto/                   # Data transfer objects
│  │  └─ StarWarsServiceProvider.php
│  ├─ Stats/                    # Domain: Analytics & stats
│  │  ├─ Actions/               # Stats computation logic
│  │  ├─ Commands/              # Artisan commands (stats:compute)
│  │  ├─ Contracts/             # Logger contracts
│  │  ├─ Events/                # Domain events (MoviesQueried, PersonViewed, etc.)
│  │  ├─ LoggerAnalytics/       # Event logging and analytics
│  │  ├─ Middleware/            # Stats tracking middleware
│  │  ├─ StatsController.php    # Stats API endpoint
│  │  └─ StatsServiceProvider.php
│  ├─ Movies/                   # Domain: Movies
│  │  ├─ Actions/               # Movie business logic
│  │  ├─ Dto/                   # Movie data transfer objects
│  │  ├─ Models/                # Movie Eloquent model
│  │  ├─ Requests/              # Form request validation
│  │  └─ MoviesController.php   # Movies API endpoints
│  ├─ People/                   # Domain: People
│  │  ├─ Actions/               # People business logic
│  │  ├─ Dto/                   # People data transfer objects
│  │  ├─ Models/                # Person Eloquent model
│  │  ├─ Requests/              # Form request validation
│  │  └─ PeopleController.php   # People API endpoints
│  ├─ Http/                     # Shared HTTP layer
│  │  ├─ Controllers/           # Base controllers
│  │  └─ Requests/              # Shared form requests
│  └─ Support/                  # Shared utilities
│     ├─ Http/                  # HTTP helpers
│     ├─ RouteName.php          # Route name constants
│     └─ TimeTracker.php        # Performance timing utility
├─ bootstrap/
│  ├─ app.php                   # Routing, middleware, exceptions
│  └─ providers.php             # Service provider registration
├─ routes/
│  ├─ api.php                   # API routes
│  ├─ web.php                   # Web routes
│  └─ console.php               # Scheduled tasks
├─ database/
│  ├─ migrations/               # Database migrations
│  ├─ factories/                # Model factories
│  └─ seeders/                  # Database seeders
├─ tests/                       # Pest tests (Feature, Unit)
├─ config/                      # Configuration files
├─ resources/                   # Views, assets
└─ public/                      # Public entry point
```

## Conventions

- **Actions**: Encapsulate business logic (no console/UI concerns)
- **Commands**: Handle console IO and delegate to Actions
- **Auto-discovery**: Commands under `app/*/Commands` are auto-discovered by Laravel 12
- **Scheduled tasks**: Defined in `routes/console.php`
- **Eloquent First**: Prefer Eloquent models and relationships over raw queries
- **Code Style**: Use `vendor/bin/pint --dirty` for consistent formatting

## Quick Start

### Prerequisites
- PHP 8.4+
- Composer
- Node.js and npm
- MySQL 8.0 (or use Docker setup from project root)

### Setup & Run

**Recommended (full dev environment):**
```zsh
composer run setup   # Install deps, create .env, generate key, run migrations, build assets
composer run dev     # Run: PHP server, queue listener, logs, Vite dev server, scheduler
```

The API will be available at http://127.0.0.1:8000. Stop all processes with Ctrl+C.

**Minimal (API only):**
```zsh
composer install
cp .env.example .env || true
php artisan key:generate
php artisan migrate --force
npm install
php artisan serve

# In another terminal for asset compilation
npm run dev
```

### First-time Data Sync

After setup, sync Star Wars data from SWAPI:
```zsh
php artisan starwars:sync
```

This fetches and caches all movies and people data from the official Star Wars API.

## API Routes

All routes are prefixed with `/api` and include automatic stats tracking middleware.

### People

- **`GET /api/people`** - Search people by name
  - Query params: `name` (string, optional)
  - Middleware: `PeopleQueriedStatsMiddleware`
  - Route name: `people.index`

- **`GET /api/people/{id}`** - Get person details by ID
  - Path params: `id` (integer)
  - Middleware: `PersonViewedStatsMiddleware`
  - Route name: `people.show`

### Movies

- **`GET /api/movies`** - Search movies by title
  - Query params: `title` (string, optional)
  - Middleware: `MoviesQueriedStatsMiddleware`
  - Route name: `movies.index`

- **`GET /api/movies/{id}`** - Get movie details by ID
  - Path params: `id` (integer)
  - Middleware: `MovieViewedStatsMiddleware`
  - Route name: `movies.show`

### Stats

- **`GET /api/stats`** - Get analytics dashboard data
  - Returns: Top movie queries, top person queries, average request times, popular hours
  - Route name: `stats.index`

## Artisan Commands

### StarWars Module

- **`php artisan starwars:sync`** - Run full sync (people first, then films)
- **`php artisan starwars:sync:people`** - Sync only people from SWAPI
- **`php artisan starwars:sync:films`** - Sync only films from SWAPI

### Stats Module

- **`php artisan stats:compute`** - Compute and display analytics from event logs
  - Displays tables for:
    - Top movie queries (percentage)
    - Top person queries (percentage)
    - Average request times by endpoint
    - Most popular hours of day (UTC)

### Standard Laravel Commands

- **`php artisan migrate`** - Run database migrations
- **`php artisan db:seed`** - Seed database
- **`php artisan test`** - Run Pest test suite
- **`php artisan serve`** - Start development server
- **`php artisan queue:listen`** - Process queue jobs
- **`php artisan schedule:work`** - Run task scheduler

## Domain Modules

### StarWars Module
Handles integration with the external Star Wars API (SWAPI). Contains:
- HTTP adapters for SWAPI communication
- Sync actions for fetching and storing data
- Commands for manual data synchronization
- DTOs for mapping SWAPI responses

### Movies Module
Manages movie data and endpoints. Features:
- Search movies by title
- Retrieve movie details
- Eloquent model with relationships
- Request validation

### People Module
Manages character data and endpoints. Features:
- Search people by name
- Retrieve person details
- Eloquent model with relationships
- Request validation

### Stats Module
Analytics and tracking system. Features:
- Event-driven logging via middleware
- Stats computation actions
- Analytics dashboard API
- Tracks: queries, views, request times, usage patterns

### Support Module
Shared utilities:
- `RouteName`: Route name constants for type-safe routing
- `TimeTracker`: Performance timing helper
- HTTP helpers for common operations

## Composer Scripts

- **`composer run setup`** - Full project setup (deps, env, key, migrations, assets)
- **`composer run dev`** - Start full dev environment (server, queue, logs, vite, scheduler)
- **`composer run test`** - Run Pest test suite

## Docker Integration

When running via `./stack start` from the project root:
- API runs on port **8800** (mapped from container port 8000)
- Connects to MySQL service via Docker network
- Code is bind-mounted for hot reload: `./star-wars-api -> /var/www/html`
- Environment variables configured for Docker networking

## Troubleshooting

- **Vite manifest error**: Run `npm run dev` or `npm run build`
- **Frontend changes not visible**: Ensure `npm run dev` is running
- **Database connection issues**: Check `.env` database credentials match your MySQL setup
- **Missing data**: Run `php artisan starwars:sync` to populate database

## Testing

Run the Pest test suite:
```zsh
composer run test
# or
php artisan test
```

Tests are organized in `tests/Feature` and `tests/Unit`.
