FROM php:8.4-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git \
       unzip \
       curl \
       gnupg \
       ca-certificates \
       procps \
       libzip-dev \
       libicu-dev \
       libonig-dev \
    && docker-php-ext-install \
       pdo_mysql \
       intl \
       bcmath \
       zip \
       pcntl \
    # Install Node.js 24.x (for building assets, tooling)
    && curl -fsSL https://deb.nodesource.com/setup_24.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && node -v && npm -v \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD ["sh", "-c", "composer run-script dev --no-interaction || true"]
