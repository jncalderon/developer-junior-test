#!/usr/bin/env bash
set -euo pipefail

[ -f .env ] || cp .env.example .env
mkdir -p bootstrap/cache database storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs
touch database/database.sqlite

if [ ! -f vendor/autoload.php ]; then
  echo "Installing dependencies with Docker..."
  docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$PWD:/app" \
    -w /app \
    composer:2 \
    composer install --no-interaction --prefer-dist
fi

./vendor/bin/sail up -d --build
./vendor/bin/sail artisan key:generate --force
./vendor/bin/sail artisan migrate:fresh --seed

app_port="${APP_PORT:-8080}"
for attempt in {1..30}; do
  if curl --silent --fail --output /dev/null "http://localhost:${app_port}/up"; then
    printf '\nReady: http://localhost:%s\n' "$app_port"
    exit 0
  fi
  sleep 1
done

echo "Error: the container started, but http://localhost:${app_port} is not responding." >&2
echo "Check the logs with: ./vendor/bin/sail logs" >&2
exit 1
