FROM php:7.1.8-fpm-alpine

# Timezone and locale
ENV TIMEZONE Europe/Moscow
ENV TZ Europe/Moscow

RUN apk update \
    && apk add postgresql-dev libxml2-dev tzdata zlib-dev curl-dev \
    && docker-php-ext-install pdo pdo_mysql soap \
    && docker-php-ext-install zip curl mbstring tokenizer \
    && cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime  \
    && echo "${TIMEZONE}" > /etc/timezone \
    && apk del tzdata \
    && apk del postgresql-dev \
    && apk add libpq

RUN adduser -D -u 1000 appuser \
    && addgroup appuser www-data \
    && addgroup www-data appuser \
    && echo 'date.timezone = ${TIMEZONE}' >> /usr/local/etc/php/php.ini

COPY ./run.sh /app/
RUN chmod +x /app/run.sh

USER 1000

WORKDIR /app/htdocs

CMD ["/app/run.sh"]
