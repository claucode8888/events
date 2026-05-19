FROM php:8.5-cli

WORKDIR /app

# Install system deps
RUN set -ex; \
    apt-get update; \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        build-essential \
        autoconf \
    ; \
    docker-php-ext-configure gd --with-freetype --with-jpeg; \
    docker-php-ext-install -j$(nproc) \
        zip \
        pdo \
        pdo_mysql \
        mbstring \
        intl \
        gd; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*
    
# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create .env
RUN printf 'APP_ENV=prod\nAPP_DEBUG=0\nAPP_SECRET=dummy_build_secret\nAPP_SHARE_DIR=var/share\nDATABASE_URL=mysql://dummy:dummy@127.0.0.1:3306/dummy?serverVersion=8.0\nMESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0\nMAILER_DSN=null://null\nDEFAULT_URI=http://localhost\n' > /app/.env

# Set environment
ENV APP_ENV=prod
ENV APP_DEBUG=0

# Copy project
COPY . .

# Install dependencies (production only)
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader
RUN COMPOSER_ALLOW_SUPERUSER=1 composer require symfony/google-mailer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer require symfony/asset-mapper

# Run Symfony commands
RUN php bin/console cache:clear --env=prod --no-debug && \
    php bin/console importmap:install --env=prod && \
    php bin/console tailwind:build --minify && \
    php bin/console asset-map:compile --env=prod

# Permissions
RUN mkdir -p var && chmod -R 775 var

# Expose port
EXPOSE 8080

# Start server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]

