FROM php:8.2.6-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
# for mysqli if you want
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
CMD ["composer", "install"]
