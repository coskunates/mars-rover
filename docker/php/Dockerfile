FROM php:8.1.0alpha3-fpm-alpine

ENV WORKDIR=/var/www/service

# Updates and installs system dependencies
RUN apk add --update --no-cache \
  bash \
  tzdata \
  libxml2-dev \
  libpng-dev \
  libjpeg-turbo-dev \
  freetype-dev \
  postgresql-dev \
  libzip-dev \
  libxslt-dev \
  oniguruma-dev \
  $PHPIZE_DEPS && \
  rm -rf /var/cache/apk/*

# Install php dependencies
RUN docker-php-ext-install \
  -j$(nproc) gd \
  iconv \
  bcmath \
  mbstring \
  pdo \
  pdo_mysql \
  sockets \
  mysqli \
  zip \
  opcache \
  intl \
  xsl \
  exif \
  soap

# Install pecl
RUN pecl -v install pcov && docker-php-ext-enable pcov

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Workdir
WORKDIR ${WORKDIR}

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD php-fpm