FROM php:8.3-fpm

WORKDIR /var/www/

RUN apt-get update && apt-get install -y \
      apt-utils \
      git \
      libpng-dev \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libzip-dev \
      zip unzip \
      libpq-dev && \
      curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
      apt-get install -y nodejs && \
      pecl install redis && \
      docker-php-ext-enable redis && \
      docker-php-ext-install pdo pdo_pgsql && \
      docker-php-ext-install sockets && \
      docker-php-ext-configure gd --with-freetype --with-jpeg && \
      docker-php-ext-install -j$(nproc) gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --chown=root:root . .

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN composer install

# Установим Node.js и npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установим зависимости npm
RUN npm install
