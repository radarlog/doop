ARG PHP_FPM_IMAGE=php:8.0-fpm-alpine3.13
ARG COMPOSER_IMAGE=composer:2.0

FROM $PHP_FPM_IMAGE AS builder

ENV BUILD_DEPS="postgresql-dev"

ARG PCOV_VERSION=1.0.9
ARG XDEBUG_VERSION=3.0.4

RUN set -e \
    #
    # Install dependencies
    && apk --no-cache add --update $PHPIZE_DEPS $BUILD_DEPS \
    #
    # Add PCOV and Xdebug extensions
    && pecl bundle -d /usr/src/php/ext pcov-$PCOV_VERSION \
    && pecl bundle -d /usr/src/php/ext xdebug-$XDEBUG_VERSION \
    #
    # Configure and install extensions
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && docker-php-ext-install -j$(nproc) \
        opcache \
        pcntl \
        pcov \
        pdo_pgsql \
        xdebug


# base image
FROM $PHP_FPM_IMAGE AS base

ENV RUNTIME_DEPS="postgresql-libs"

RUN set -e \
    && cd /tmp \
    #
    # Install dependencies
    && apk --no-cache add --update $RUNTIME_DEPS \
    && rm -rf /tmp/* /var/cache/apk/*

ARG MYUSER=app
ARG MYGROUP=app
ARG MYUID=1000
ARG MYGID=1001

RUN set -e \
    #
    # Add runtime user
    && addgroup -g $MYGID $MYGROUP  \
    && adduser -u $MYUID -S -D -G $MYGROUP $MYUSER

ENV APP_DIR=/app
WORKDIR $APP_DIR/
RUN chown $MYUSER:$MYGROUP $APP_DIR/
USER $MYUSER

ENV PHP_DISPLAY_ERRORS=0
ENV PHP_EXPOSE=0
ENV PHP_MEMORY_LIMIT=128M
ENV PHP_POST_MAX_SIZE=1M
ENV PHP_UPLOAD_MAX_FILESIZE=1M
ENV PHP_MAX_EXECUTION_TIME=300

ENV XDEBUG_MODE=off

ENV PHP_LIB_DIR=/usr/local/lib/php

COPY php.ini $PHP_INI_DIR/
COPY --from=builder $PHP_LIB_DIR/extensions/ $PHP_LIB_DIR/extensions/
COPY --from=builder $PHP_INI_DIR/conf.d/ $PHP_INI_DIR/conf.d/

EXPOSE 9000
CMD ["php-fpm", "--nodaemonize"]


# development dependencies
FROM $COMPOSER_IMAGE AS composer


# development/test/ci image
FROM base AS development

COPY --from=composer /usr/bin/composer /usr/local/bin/

ENV PHP_DISPLAY_ERRORS=1
ENV PHP_EXPOSE=1
