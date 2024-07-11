FROM php:8.3-alpine

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN apk add --no-cache zip libzip-dev \
    && docker-php-ext-install pdo_pgsql

RUN  curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/bin/composer

COPY . /app

WORKDIR /app
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-interaction --no-progress --no-suggest
RUN bin/console doctrine:schema:update --force

CMD ["php", "bin/react-php-server"]