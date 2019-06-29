FROM php:7.2-fpm-alpine

LABEL maintainer="denis.basov@isobar.ru"
LABEL maintainer="aleksey.kolyadin@isobar.ru"

RUN apk update                          && \
    apk upgrade                         && \
    docker-php-source extract           && \
    apk add --no-cache                     \
        --virtual .build-dependencies      \
        $PHPIZE_DEPS                       \
        zlib-dev                           \
        cyrus-sasl-dev                     \
        autoconf                           \
        g++                                \
        libtool                            \
        make                               \
        pcre-dev                        && \
    apk add --no-cache                     \
        supervisor                         \
        sudo                               \
        shadow                             \
        tini                               \
        git                                \
        bash                               \
        procps                             \
        curl                               \
        libintl                            \
        icu                                \
        icu-dev                            \
        libxml2-dev                        \
        postgresql-dev                     \
        freetype-dev                       \
        libjpeg-turbo-dev                  \
        libmcrypt-dev                      \
        libpng-dev                         \
        gmp                                \
        gmp-dev                            \
        libmemcached-dev                   \
        imagemagick-dev                    \
        libssh2                            \
        libssh2-dev                        \
        libxslt-dev                        \
        libmcrypt-dev                   && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ &&  \
    docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
        intl                                                \
        opcache                                             \
        bcmath                                              \
        xsl                                                 \
        zip                                                 \
        json                                                \
        xml                                                 \
        soap                                                \
        mbstring                                            \
        mysqli                                              \
        pdo                                                 \
        pdo_mysql                                           \
        pdo_pgsql                                           \
        gmp                                                 \
        iconv                                               \
        gd                                               && \
    pecl install imagick ssh2-1.1.2                      && \
    docker-php-ext-enable imagick ssh2                   && \
    echo "expose_php=0" > /usr/local/etc/php/php.ini            && \
    echo 'www-data  ALL=(ALL:ALL) NOPASSWD: ALL' > /etc/sudoers.d/www-data && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
    apk del .build-dependencies                                 && \
    docker-php-source delete                                    && \
    rm -rf /tmp/* /var/cache/apk/*

RUN usermod -u 1000 www-data

CMD ["supervisord", "-c", "/etc/supervisord.conf", "-n", "-j", "/supervisord.pid"]