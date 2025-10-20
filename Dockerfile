# Imagem base com PHP e Apache
FROM php:8.3-apache

# Instala dependências e extensões do PHP necessárias para Laravel
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# Habilita mod_rewrite (necessário para rotas do Laravel)
RUN a2enmod rewrite

# Define diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do Laravel para o container
COPY . .

# Instala dependências do Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader \
    && rm composer-setup.php

# Corrige permissões de pastas
RUN chown -R www-data:www-data storage bootstrap/cache

# Ajusta o DocumentRoot para a pasta public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 🔧 Ativa o uso do .htaccess dentro de /public (ESSENCIAL)
RUN echo '<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Expõe a porta 10000 (Render exige isso)
EXPOSE 10000

# Inicia o Apache
CMD ["apache2-foreground"]
