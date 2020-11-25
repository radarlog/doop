FROM php:7.4-fpm-alpine3.12 as development

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/

ENV BUILD_DEPS $PHPIZE_DEPS postgresql-dev
ENV RUNTIME_DEPS postgresql-libs

ENV XDEBUG_VERSION 3.0.0

RUN set -e \
    && cd /tmp \
    #
    # Install dependencies
    && apk --no-cache add --update $BUILD_DEPS $RUNTIME_DEPS \
    #
    # Configure and install extensions
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && docker-php-ext-install \
        fileinfo \
        opcache \
        pdo_pgsql \
    #
    # Compile PCOV and Xdebug extensions
    && yes | pecl install pcov \
    && docker-php-ext-enable pcov \
    && yes | pecl install xdebug-$XDEBUG_VERSION \
    && docker-php-ext-enable xdebug \
    #
    # Clean up
    && apk del --purge $BUILD_DEPS \
    && rm -rf /tmp/* /var/cache/apk/*

ENV PHP_DISPLAY_ERRORS 1
ENV PHP_EXPOSE 1

ENV PHP_LOG_ERRORS 1
ENV PHP_POST_MAX_SIZE 1G
ENV PHP_UPLOAD_MAX_FILESIZE 1G
ENV PHP_MAX_EXECUTION_TIME 300
ENV PHP_MEMORY_LIMIT 128M

ENV PHP_OPCACHE_ENABLE 1
ENV PHP_OPCACHE_ENABLE_CLI 1
ENV PHP_OPCACHE_FAST_SHUTDOWN 1
ENV PHP_OPCACHE_INTERNED_STRINGS_BUFFER 8
ENV PHP_OPCACHE_MEMORY_CONSUMPTION 128
ENV PHP_OPCACHE_MAX_ACCELERATED_FILES 5000
ENV PHP_OPCACHE_REVALIDATE_FREQ 2
ENV PHP_OPCACHE_SAVE_COMMENTS 1

ENV XDEBUG_MODE debug

COPY php.ini $PHP_INI_DIR/

ENV WORK_DIR /app
WORKDIR $WORK_DIR

EXPOSE 9000

CMD ["php-fpm", "--nodaemonize"]
