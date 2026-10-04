FROM php:8.2-apache

# Install system dependencies and PHP extensions required by CodeIgniter 4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) intl mbstring mysqli pdo pdo_mysql gd zip \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Point Apache DocumentRoot to CodeIgniter's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable .htaccess overrides and configure environment variables passing
RUN printf '<Directory /var/www/html/public>\n    Options -Indexes +FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>\n' >> /etc/apache2/apache2.conf \
    && printf 'PassEnv MYSQLHOST MYSQLUSER MYSQLPASSWORD MYSQLDATABASE MYSQLPORT MYSQL_URL DATABASE_URL RAILWAY_PUBLIC_DOMAIN CI_ENVIRONMENT APP_BASE_URL PORT\n' >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Ensure directories exist, set permissions, normalize start.sh line endings, and make it executable
RUN mkdir -p /var/www/html/writable/cache \
             /var/www/html/writable/logs \
             /var/www/html/writable/session \
             /var/www/html/writable/debugbar \
             /var/www/html/public/uploads/avatars \
             /var/www/html/public/uploads/products \
    && chmod -R 777 /var/www/html/writable /var/www/html/public/uploads \
    && sed -i 's/\r$//' /var/www/html/start.sh \
    && chmod +x /var/www/html/start.sh

CMD ["/var/www/html/start.sh"]
