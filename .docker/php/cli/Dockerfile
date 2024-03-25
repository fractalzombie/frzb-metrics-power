ARG VERSION_PHP

FROM php:${VERSION_PHP}-cli-alpine

ARG USER_ID
ARG GROUP_ID
ARG USER_NAME
ARG GROUP_NAME

ARG VERSION_AMQP=stable
ARG VERSION_APCU=stable
ARG VERSION_XDEBUG=stable

ENV PATH=${HOME}/.composer/vendor/bin:${PATH}

# Download script to install PHP extensions and dependencies
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

# install system utilities
RUN apk add --no-cache \
    sudo \
    curl \
    nano \
    bash \
    gnupg \
    zip unzip \
    git \
    ca-certificates \
    linux-headers \
    openssh

# Install PHP
RUN install-php-extensions \
    bcmath \
    bz2 \
    pcntl \
    calendar \
    exif \
    gd \
    intl \
    opcache \
    redis \
    soap \
    xsl \
    gmp \
    zip \
    ssh2 \
    sockets \
    pdo_mysql \
    mysqli \
    excimer \
    apcu-${VERSION_APCU} \
    xdebug-${VERSION_XDEBUG} \
    amqp-${VERSION_AMQP} \
    @composer

# Install symfony cli
RUN curl -LsS https://get.symfony.com/cli/installer -o /usr/local/bin/symfony \
 && chmod a+x /usr/local/bin/symfony

# Install bash commands
COPY scripts/start-consumer /usr/local/bin/start-consumer
COPY scripts/start-command /usr/local/bin/start-command
RUN chmod a+x /usr/local/bin/start-consumer && \
    chmod a+x /usr/local/bin/start-command

# Configure PHP
COPY conf/docker-php-ext-xdebug.ini ${PHP_INI_DIR}/conf.d/docker-php-ext-xdebug.ini
COPY conf/docker-php-ext-opcache.ini ${PHP_INI_DIR}/conf.d/docker-php-ext-opcache.ini
COPY conf/php.production.ini ${PHP_INI_DIR}/php.ini

RUN apk add --no-cache sudo && \
    addgroup --gid "${GROUP_ID}" -S ${GROUP_NAME} && \
    adduser --uid "${USER_ID}" -S ${USER_NAME} -G ${GROUP_NAME} --disabled-password && \
    addgroup ${USER_NAME} www-data && \
    addgroup ${USER_NAME} root && \
    echo '${USER_NAME} ALL=(ALL) NOPASSWD: ALL' >> "/etc/sudoers"

WORKDIR /var/www/html
USER ${USER_NAME}
