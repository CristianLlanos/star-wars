# Star Wars Stack

This repo contains two apps:
- `star-wars-api`: Laravel API (PHP 8.4)
- `star-wars-web`: Next.js app (Node 24)

## Prerequisites
- Docker Engine
- Docker Compose
- zsh, bash (for the stack script)

## Quick start

Make sure the `./stack` script is executable:
```zsh
chmod +x ./stack
```

Keep in mind that the first run may take a few minutes to set up everything.
Also, the web app may take a minute to be available as it needs to build the Next.js app.

```zsh
# Start the stack (will setup API and setup MySQL seed data on first run)
./stack start

# Remove the stack when done (stops and removes containers, networks, volumes, and images created by up)
./stack down
```

## Services
- Web: http://localhost:8900
- Stats: http://localhost:8900/dashboard
- API: http://localhost:8800
- MySQL: host 127.0.0.1:3366 (db `starwars`, user `starwars`, pass `starwars`)

## Volumes and live reload
- API code: bind-mounted `./star-wars-api -> /var/www/html`
- Web code: bind-mounted `./star-wars-web -> /app`
- MySQL data: bind-mounted `./.mysql/data -> /var/lib/mysql`

## Environment
- Web client uses `NEXT_PUBLIC_API_BASE_URL=http://localhost:8800` from `star-wars-web/.env.local`
- Web server-side calls can use `API_BASE_URL=http://api:8000` (Docker network)
- Laravel `.env` is configured to connect to the `mysql` service

## Useful commands
```zsh
# Use the stack aggregator to manage the environment
./stack --help          # show usage and available commands

# open a shell in the API container
docker compose exec api sh

# run migrations
docker compose exec api php artisan migrate

# install API deps
docker compose exec api sh -lc 'composer install'

# install web deps
docker compose exec web sh -lc 'npm install'
```

## View Logs
```zsh
# (all services)
./stack logs
# logs (specific services)
./stack logs api web
```

## The start script

The `./stack start` command is an startup script that manages the entire development environment:

**What it does:**
- **First-run detection**: Automatically detects if this is your first time running the stack and performs one-time setup
- **Setup bootstrapping**: Runs `./stack setup` on first run to install dependencies, run migrations, and seed the database
- **Docker orchestration**: Builds and starts all Docker containers (API, Web, MySQL) in detached mode
- **Readiness monitoring**: Waits for the Next.js web app to be fully ready before proceeding
- **Service URLs**: Displays access URLs for the API and Web app once ready
- **Log attachment**: Prompts you to optionally attach live logs for debugging

**Options:**
- `./stack start --setup`: Forces setup to run even if already bootstrapped
- `./stack start --setup --no-cache`: Rebuilds Docker images without cache
- `./stack start --setup --no-seed`: Skips database seeding during setup

The script creates a `.bootstrapped` marker file after the first successful setup to avoid re-running setup on subsequent starts.
