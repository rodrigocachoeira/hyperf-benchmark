FROM phpswoole/swoole:php8.3-alpine

ARG timezone
ARG APP_ENV=local
ARG APP_NAME=demo

ENV TIMEZONE=${timezone:-"America/Los_Angeles"} \
  APP_ENV=$APP_ENV \
  APP_NAME=$APP_NAME \
  SCAN_CACHEABLE=(true)

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . /var/www

WORKDIR /var/www

RUN set -ex \
  && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install pcntl \
  && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
  && echo "${TIMEZONE}" > /etc/timezone \
  && { \
  echo "memory_limit=1G"; \
  echo "date.timezone=${TIMEZONE}"; \
  } | tee /usr/local/etc/php/conf.d/overrides.ini \
  && echo "swoole.use_shortname = 'Off'" >> /usr/local/etc/php/conf.d/docker-php-ext-swoole.ini \
  && composer install -nq --no-progress && php ./bin/hyperf.php \
  && composer clearcache \
  && rm -rf /var/cache/apk/* /tmp/* /usr/share/man /usr/src/php.tar.xz* $HOME/.composer/*-old.phar

EXPOSE 9501

# ENTRYPOINT ["php", "/var/www/bin/hyperf.php", "server:watch"]