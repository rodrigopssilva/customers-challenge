FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libpq-dev \
	git \
	libzip-dev \
	zip \
	sqlite3 \
	libsqlite3-dev \
	&& docker-php-ext-install -j$(nproc) iconv \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd \
	&& docker-php-ext-configure pdo_pgsql \
	&& docker-php-ext-install pdo_pgsql \
	&& docker-php-ext-configure zip --with-libzip \
	&& docker-php-ext-install zip \
	&& docker-php-ext-configure pdo_sqlite \
	&& docker-php-ext-install pdo_sqlite \
	&& pecl install swoole \
	&& pecl install xdebug-2.9.2 \
	&& docker-php-ext-enable swoole \
	&& docker-php-ext-enable xdebug \
	&& apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
