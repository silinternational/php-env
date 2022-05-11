FROM php:8.1

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Install PHP extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions zip

WORKDIR /data
