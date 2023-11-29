ARG PHP_FPM_IMAGE=php:8.3-fpm-alpine
ARG COMPOSER_IMAGE=composer:2.6
ARG PHP_EXTENSION_INSTALLER=mlocati/php-extension-installer:2.1

# development dependencies
FROM $PHP_EXTENSION_INSTALLER AS php_extension_installer
FROM $COMPOSER_IMAGE AS composer


# builder image
FROM $PHP_FPM_IMAGE AS builder

ARG XDEBUG_VERSION=3.3.0alpha3

COPY --from=php_extension_installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -e \
    #
    # Install dependencies
    && install-php-extensions  \
        opcache \
        pcntl \
        pdo_pgsql \
        xdebug-$XDEBUG_VERSION


# base image
FROM $PHP_FPM_IMAGE AS base

ENV RUNTIME_DEPS="postgresql-libs"

RUN set -e \
    && cd /tmp \
    #
    # Apply security updates and bugfixes \
    && apk --update-cache upgrade \
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
RUN set -e \
    chown $MYUSER:$MYGROUP $APP_DIR/ \
    setfacl -dR -m u:$MYUSER:rwX -m u:root:rwX $APP_DIR/var/ \
    setfacl -R -m u:$MYUSER:rwX -m u:root:rwX $APP_DIR/var/
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


# development/test/ci image
FROM base AS development

COPY --from=composer /usr/bin/composer /usr/local/bin/

ENV PHP_DISPLAY_ERRORS=1
ENV PHP_EXPOSE=1
