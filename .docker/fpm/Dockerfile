FROM php:8.3-fpm-alpine

COPY configs/php.ini "$PHP_INI_DIR/php.ini"
RUN rm -f /etc/php7/php-fpm.d/www.conf
COPY configs/default.conf /usr/local/etc/php-fpm.d/default.conf

ARG COMPOSER_BIN=/usr/bin/composer
ARG COMPOSER_VERSION=2.2.12
ARG COMPOSER_SHA256SUM=1ce90687eb3f89a99c059d45dd419d08430ed249468544b932b1dad7fb22dda0

RUN set -ex ;\
  wget -O "$COMPOSER_BIN" "https://getcomposer.org/download/$COMPOSER_VERSION/composer.phar" ;\
  printf "%s  %s\n" "$COMPOSER_SHA256SUM" "$COMPOSER_BIN" | sha256sum -c - ;\
  chmod +x -- "$COMPOSER_BIN" ;\
  composer --version ;\
  composer diagnose || printf 'composer diagnose exited: %d\n' $? ;\
  :

RUN apk add --no-cache --update linux-headers autoconf freetype libpng libjpeg-turbo freetype-dev gcc g++ make\
    libpng-dev libjpeg-turbo-dev icu-dev ffmpeg libzip-dev libzip \
    && sed -i 's|$PHP -C -n -q |$PHP -C -q |' /usr/local/bin/pecl \
    && pecl install xdebug \
    && docker-php-ext-configure gd \
    && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
    && docker-php-ext-install -j${NPROC} gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl zip \
    && docker-php-ext-enable xdebug \
    && apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

WORKDIR /application

CMD [ "php-fpm", "-F", "--pid", "/var/run/php-fpm.pid", "-y", "/usr/local/etc/php-fpm.conf" ]
