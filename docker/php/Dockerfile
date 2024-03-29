FROM php:7.4.11-fpm-alpine

ARG APCU_VERSION=5.1.19
ARG XDEBUG_VERSION=3.1.5
ARG COMPOSER_VERSION=2.0.8

RUN apk add --update --no-cache \
        bash \
        ca-certificates \
        git \
        icu-libs \
        libxml2-dev \
        unzip \
        zip \
        oniguruma-dev \
        su-exec \
        libzip-dev && \
    apk add --update --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev && \
    pecl install apcu-${APCU_VERSION} xdebug-${XDEBUG_VERSION} && \
    docker-php-ext-install intl zip mysqli pdo_mysql && \
    docker-php-ext-enable opcache apcu xdebug && \
    apk del .build-deps && \
    addgroup bar && \
    adduser -D -h /home -s /bin/bash -G bar foo

# Composer
RUN curl -sS https://getcomposer.org/installer \
        | php -- --filename=composer --install-dir=/usr/local/bin --version=${COMPOSER_VERSION}

ADD entrypoint.sh /entrypoint
COPY config/php.ini /usr/local/etc/php/php.ini
COPY config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /srv

ENTRYPOINT ["/entrypoint"]
