FROM php:7.3.9-fpm-alpine3.10 as development

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
COPY --from=composer:latest /usr/bin/composer /usr/bin

ENV BUILD_DEPS $PHPIZE_DEPS imagemagick-dev libjpeg-turbo-dev libpng-dev libtool postgresql-dev
ENV RUNTIME_DEPS imagemagick postgresql-libs

ENV XDEBUG_VERSION 2.7.2
ENV IMAGICK_VERSION 3.4.4

RUN set -e \
    && cd /tmp \
    #
    # Set timezone
    && ln -fs /usr/share/zoneinfo/UTC /etc/localtime \
    #
    # Install dependencies
    && apk --no-cache add --update $BUILD_DEPS $RUNTIME_DEPS \
    #
    # Configure and install extensions
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && docker-php-ext-install \
        exif \
        opcache \
        pdo_pgsql \
    #
    # Compile and enable imagick extension
    && pecl install imagick-$IMAGICK_VERSION \
    && docker-php-ext-enable imagick \
    #
    # Compile Xdebug extension
    && pecl install xdebug-$XDEBUG_VERSION \
    #
    # Clean up
    && apk del --purge $BUILD_DEPS \
    && rm -rf /tmp/* /var/cache/apk/* /var/lib/apt/lists/*

ENV PHP_DISPLAY_ERRORS 1
ENV PHP_EXPOSE 1

ENV PHP_XDEBUG_ENABLE 1

ENV PHP_LOG_ERRORS 1
ENV PHP_POST_MAX_SIZE 1G
ENV PHP_UPLOAD_MAX_FILESIZE 1G
ENV PHP_MAX_EXECUTION_TIME 300

ENV PHP_OPCACHE_ENABLE 1
ENV PHP_OPCACHE_ENABLE_CLI 1
ENV PHP_OPCACHE_FAST_SHUTDOWN 1
ENV PHP_OPCACHE_INTERNED_STRINGS_BUFFER 8
ENV PHP_OPCACHE_MEMORY_CONSUMPTION 128
ENV PHP_OPCACHE_MAX_ACCELERATED_FILES 5000
ENV PHP_OPCACHE_REVALIDATE_FREQ 2
ENV PHP_OPCACHE_SAVE_COMMENTS 1

COPY php.ini $PHP_INI_DIR/
COPY xdebug.ini $PHP_INI_DIR/conf.d/

ENV WORK_DIR /app
WORKDIR $WORK_DIR

EXPOSE 9000

CMD ["php-fpm", "--nodaemonize"]
