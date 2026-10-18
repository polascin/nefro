FROM node:22-bookworm-slim@sha256:c3de60bf2f9dd0ac6370e6117950ff62d6e339527e7472301c9c78a017978392 AS node
FROM php:8.5.8-cli-bookworm@sha256:fb740987f3e7aefd7f52d1f961fa91602874f2b6a5b0bf0105725f8987b54bee
RUN apt-get update && apt-get install -y --no-install-recommends libonig-dev libxml2-dev libcurl4-openssl-dev libsqlite3-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev ca-certificates openssl git unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j2 pdo_mysql pdo_sqlite mbstring curl gd \
    && rm -rf /var/lib/apt/lists/*
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN curl -fsSL https://github.com/phpstan/phpstan/releases/download/2.2.2/phpstan.phar -o /usr/local/bin/phpstan.phar \
    && echo '487ab20ffe29ce405cf19b4e803933aa7dd97cdb871f457ca57fc9267f5a0f1a  /usr/local/bin/phpstan.phar' | sha256sum -c -
WORKDIR /app
COPY . /app
RUN mkdir -p private pdf /test-certs \
    && printf 'date.timezone=Europe/Bratislava\nopenssl.cafile=/test-certs/smtp.crt\n' > /usr/local/etc/php/conf.d/integration.ini
ENV NEFRO_ENV_PATH=/app/tools/integration/app.ini
