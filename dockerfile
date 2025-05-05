FROM php:8.1-apache

# Povolení modulu rewrite pro Apache
RUN a2enmod rewrite

# Nastavení pracovního adresáře
WORKDIR /var/www/html

# Kopírování souborů aplikace do kontejneru
COPY . /var/www/html

# Instalace PostgreSQL rozšíření pro PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql

# Otevření portu 80 pro Apache
EXPOSE 80

# Spuštění Apache serveru
CMD ["apache2-foreground"]
