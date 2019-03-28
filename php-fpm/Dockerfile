FROM php:7.3.3-fpm-alpine

RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    zlib-dev libzip-dev

RUN docker-php-ext-configure zip && docker-php-ext-install zip pdo_mysql

ARG PROJECT_DIR
ARG SRC_DIR_APP

RUN mkdir -p ${PROJECT_DIR}

WORKDIR ${PROJECT_DIR}

COPY ${SRC_DIR_APP} ${PROJECT_DIR}

EXPOSE 9000

CMD ["php-fpm"]
