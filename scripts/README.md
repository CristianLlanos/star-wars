# Stack Scripts

This directory contains shell scripts for managing the Star Wars Stack development environment. All scripts are designed to be executed via the `./stack` wrapper from the project root.

## Script Overview

| Script | Purpose | Usage |
|--------|---------|-------|
| `start` | Start the development stack | `./stack start [--setup] [options]` |
| `setup` | One-time project setup | `./stack setup [--no-seed] [--no-cache]` |
| `seed` | Import SQL data into MySQL | `./stack seed [path/to/file.sql]` |
| `logs` | View and follow logs | `./stack logs [service...] [--since=1m]` |
| `stop` | Stop services (preserve containers) | `./stack stop [--timeout 30]` |
| `down` | Teardown stack completely | `./stack down [-v] [--remove-orphans]` |

## Scripts in Detail

### `start`

**Purpose**: Intelligent startup script that brings up the entire development stack with automatic first-run detection and setup.

**What it does**:
1. Detects if this is the first run (checks for `.bootstrapped` marker file)
2. If first run or `--setup` flag provided, runs the `setup` script
3. Builds and starts all Docker containers in detached mode
4. Waits for the Next.js web app to be ready (watches for "✓ Ready" in logs)
5. Shows a spinner during the waiting period
6. Displays service URLs once ready
7. Optionally attaches live logs (user prompt)

**Options**:
- `--setup` or `setup` - Force setup to run even if already bootstrapped
- All `setup` options can be passed through (e.g., `--no-seed`, `--no-cache`)

**Usage**:
```bash
./stack start                      # Normal startup (runs setup on first run only)
./stack start --setup              # Force setup then start
./stack start --setup --no-cache   # Force setup with no-cache build
./stack start --setup --no-seed    # Force setup but skip database seeding
```

**Creates**: `.bootstrapped` marker file to track setup completion

---

### `setup`

**Purpose**: One-time project setup that prepares the API and database for development.

**What it does**:
1. Builds the MySQL Docker image (with optional `--no-cache`)
2. Starts the MySQL service in detached mode
3. Waits for MySQL to report healthy (up to 60 attempts, 2s intervals)
4. Runs `composer run-script setup` inside the API container, which:
   - Installs PHP dependencies
   - Creates `.env` from `.env.example`
   - Generates Laravel application key
   - Runs database migrations
   - Installs npm dependencies
   - Builds frontend assets
5. Seeds the database (unless `--no-seed` is provided)
6. Builds the API Docker image

**Options**:
- `--no-seed` - Skip database seeding after setup
- `--with-seed` - Force database seeding (default behavior)
- `--no-cache` - Build Docker images without using cache
- `--help` / `-h` - Show help message

**Usage**:
```bash
./stack setup                # Full setup with seeding
./stack setup --no-seed      # Setup without seeding
./stack setup --no-cache     # Setup with fresh image builds
```

**Environment Variables**:
- `MYSQL_CONTAINER_NAME` - MySQL container name (default: `star-wars-mysql`)

---

### `seed`

**Purpose**: Import SQL data into the MySQL service.

**What it does**:
1. Checks if SQL file exists (defaults to `star-wars.sql` in project root)
2. Ensures MySQL service is running (starts it if needed)
3. Waits for MySQL to be healthy (up to 60 attempts, 2s intervals)
4. Imports the SQL file using `mysql` client inside the container
5. SQL file can create/use its own database

**Options**:
- First argument: Path to SQL file (default: `star-wars.sql`)

**Usage**:
```bash
./stack seed                    # Import ./star-wars.sql
./stack seed custom-data.sql    # Import custom SQL file
```

**Environment Variables**:
- `MYSQL_CONTAINER_NAME` - MySQL container name (default: `star-wars-mysql`)
- `MYSQL_ROOT_PASSWORD` - MySQL root password (default: `root`)

**Notes**:
- Uses MySQL root user for import
- SQL file should handle database creation/selection
- Service will be started automatically if not running

---

### `logs`

**Purpose**: View and follow Docker Compose logs for all or specific services.

**What it does**:
- Executes `docker compose logs -f` with all passed arguments
- Follows logs in real-time (Ctrl+C to exit)

**Options**:
- Service names to filter logs (e.g., `api web`)
- Docker Compose log flags (e.g., `--since=1m`, `--tail=100`, `--no-color`)

**Usage**:
```bash
./stack logs                  # Follow all service logs
./stack logs api              # Follow only API logs
./stack logs api web          # Follow API and Web logs
./stack logs --since=1m       # Show logs from last minute
./stack logs --tail=50 api    # Show last 50 lines of API logs
```

**Examples**:
```bash
# View recent errors across all services
./stack logs --since=5m | grep -i error

# Follow web container logs with no color
./stack logs --no-color web

# View last 100 lines without following
./stack logs --tail=100 --no-follow
```

---

### `stop`

**Purpose**: Stop Docker Compose services without removing containers, networks, or volumes.

**What it does**:
- Executes `docker compose stop` with all passed arguments
- Stops containers gracefully (sends SIGTERM, waits, then SIGKILL if needed)
- Preserves container state for quick restart

**Options**:
- `--timeout` - Seconds to wait for graceful stop before force kill (default: 10)

**Usage**:
```bash
./stack stop                 # Stop all services (10s timeout)
./stack stop --timeout 30    # Stop with 30s graceful shutdown
./stack stop api             # Stop only the API service
```

**Notes**:
- Containers can be restarted quickly with `docker compose start` or `./stack start`
- Does not remove `.bootstrapped` marker or MySQL data
- Use when you want to pause development without cleanup

---

### `down`

**Purpose**: Complete teardown of the Docker Compose stack with cleanup.

**What it does**:
1. Executes `docker compose down` with all passed arguments
2. Stops and removes containers, networks, and optionally volumes
3. If successful, removes the `.bootstrapped` marker file
4. If successful, removes the `.mysql` data directory

**Options**:
- `-v` / `--volumes` - Remove named volumes declared in compose file
- `--remove-orphans` - Remove containers for services not in compose file
- Other `docker compose down` flags

**Usage**:
```bash
./stack down                    # Remove containers and networks
./stack down -v                 # Also remove volumes
./stack down --remove-orphans   # Remove orphaned containers
```

**Cleanup Actions**:
- ✅ Removes `.bootstrapped` marker (forces setup on next start)
- ✅ Removes `.mysql/` directory (local MySQL data)
- ✅ Stops and removes containers
- ✅ Removes networks created by compose
- ⚠️ Optionally removes volumes (with `-v` flag)

**Notes**:
- Use when you want a clean slate
- Next `./stack start` will trigger full setup
- Database data will be lost unless volumes are preserved

---

## Environment Variables

Scripts may reference these environment variables:

| Variable | Default | Description |
|----------|---------|-------------|
| `MYSQL_CONTAINER_NAME` | `star-wars-mysql` | Name of the MySQL container |
| `MYSQL_ROOT_PASSWORD` | `root` | MySQL root password for seeding |
| `BUILD_CACHE_FLAG` | (empty) | Set to `--no-cache` to disable Docker build cache |
| `SEED_AFTER_SETUP` | `1` | Set to `0` to skip seeding during setup |

## Common Workflows

### Fresh Start
```bash
./stack down -v        # Clean everything
./stack start          # Setup and start from scratch
```

### Quick Restart
```bash
./stack stop           # Pause development
./stack start          # Resume (skips setup)
```

### Rebuild Without Cache
```bash
./stack start --setup --no-cache
```

### View Recent Errors
```bash
./stack logs --since=10m | grep -i error
```

### Import Custom Data
```bash
./stack seed backup-2024-12-17.sql
```

## Error Handling

All scripts use `set -euo pipefail` for robust error handling:
- `set -e` - Exit on any command failure
- `set -u` - Exit on undefined variable
- `set -o pipefail` - Catch failures in pipes

The `down` script temporarily disables `set -e` to handle cleanup even if `docker compose down` fails.

## Script Dependencies

Scripts can call each other:
- `start` → calls `setup` (conditionally)
- `setup` → calls `seed` (conditionally)

All paths are resolved relative to the script location, so scripts work regardless of current working directory.
