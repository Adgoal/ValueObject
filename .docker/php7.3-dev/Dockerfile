ARG DOCKER_SERVER_HOST
ARG DOCKER_PROJECT_PATH
ARG DOCKER_PHP_VERSION
ARG DOCKER_IMAGE_VERSION=master

FROM ${DOCKER_SERVER_HOST}/${DOCKER_PROJECT_PATH}/php${DOCKER_PHP_VERSION}-composer:${DOCKER_IMAGE_VERSION}

RUN composer -vvv global require ergebnis/composer-normalize
RUN composer -vvv global require pyrech/composer-changelogs

# -------------------- Installing PHP Extension: xdebug --------------------
RUN set -eux \
    # Installation: Generic
    # Type:         PECL extension
    # Default:      Pecl command
    && pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug \
    && true

RUN set -eux \
    # Installation: Generic
    # Type:         Built-in extension
    && pecl install ast \
    && docker-php-ext-enable ast \
    && true

# -------------------- Installing PHP Extension: intl --------------------
RUN set -eux \
    # Installation: Generic
    # Type:         Built-in extension
    && apk add icu-dev \
    && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) intl \
    && true
