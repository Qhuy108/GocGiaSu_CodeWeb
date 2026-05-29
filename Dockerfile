FROM php:8.2-apache

# Cài PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Bật mod_rewrite cho Apache
RUN a2enmod rewrite

# Cho phép .htaccess override trong thư mục web
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy toàn bộ code vào document root
COPY . /var/www/html/

# Đặt quyền cho thư mục
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
