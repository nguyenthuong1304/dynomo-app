FROM php:8.1.0-fpm

ENV TERM xterm

RUN apt-get update && apt-get install -y\
    libpq-dev \
    libmemcached-dev \
    curl \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    vim \
    libzip-dev \
    zip \
    zlib1g-dev libicu-dev g++ \
    libxrender1 \
    libfontconfig \
    libxtst6 \
    libxi6 \
    wget \
    fonts-takao-gothic \
    fonts-takao-mincho \
    && rm -r /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install exif pcntl
RUN docker-php-ext-configure gd \
	--with-jpeg \
	--with-webp \
	--with-freetype \
	&& docker-php-ext-install -j$(nproc) gd

# configure intl for php - package for unicode and international language - go with libicu
RUN docker-php-ext-configure intl

# Install mongodb, xdebug
RUN pecl install mongodb \
    && pecl install redis \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install mcrypt-1.0.5 \
    && docker-php-ext-enable mcrypt

# Install extensions using the helper script provided by the base image for php
RUN docker-php-ext-configure zip \
    && docker-php-ext-install \
    bcmath \
    pdo_mysql \
    pdo_pgsql \
    gd \
    intl \
    zip

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

RUN docker-php-ext-install opcache

RUN wget https://github.com/h4cc/wkhtmltopdf-amd64/blob/master/bin/wkhtmltopdf-amd64?raw=true -O /usr/local/bin/wkhtmltopdf

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www/html

ADD ./.docker/php-fpm/config/conf.ini /usr/local/etc/php/conf.d
ADD ./.docker/php-fpm/config/opcache.ini /usr/local/etc/php/conf.d
ADD ./.docker/php-fpm/config/php-fpm.conf /usr/local/etc/php-fpm.d/

RUN sed -i 's/^CipherString/#&/' /etc/ssl/openssl.cnf
RUN chmod +x /usr/local/bin/wkhtmltopdf

EXPOSE 9000

CMD [ "php-fpm" ]
