FROM php:8.2-fpm

# Cài extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Cấu hình PHP cho môi trường dev
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Tăng giới hạn upload file (để upload CCCD, bằng cấp)
RUN echo "upload_max_filesize = 10M"  >> "$PHP_INI_DIR/php.ini" \
 && echo "post_max_size = 12M"        >> "$PHP_INI_DIR/php.ini" \
 && echo "max_execution_time = 60"    >> "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html
