# Star Wars Stack

This repo contains two apps:
- `star-wars-api`: Laravel API (PHP 8.4)
- `star-wars-web`: Next.js app (Node 24)

## Prerequisites
- Docker Desktop (macOS)

## Quick start
```zsh
# Start the stack (will setup API and setup MySQL seed data on first run)
./stack start

# Remove the stack
./stack down
```

## Services
- API: http://localhost:8000
- Web: http://localhost:8100
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