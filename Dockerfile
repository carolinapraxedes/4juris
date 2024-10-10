# Usando uma imagem base com PHP 8.2 e FPM
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    libzip-dev \
    unzip \
    git \
    curl \
    nodejs \
    npm

# Instalar extensões PHP
RUN docker-php-ext-install pdo_mysql zip exif pcntl

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar as dependências do Node.js (se usar Laravel Mix ou Vite)
RUN npm install -g npm

# Criar e definir o diretório de trabalho
WORKDIR /var/www

# Copiar os arquivos do projeto Laravel
COPY . .

# Instalar dependências do PHP e Node.js
RUN composer install --optimize-autoloader --no-dev
RUN npm install 

# Dar permissão de escrita às pastas de cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expor a porta 9000 e iniciar o PHP-FPM
# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000

# Expor a porta 5173 para o Vite
EXPOSE 5173

# Executar o servidor do Laravel e o Vite no início
CMD php artisan serve --host=0.0.0.0 --port=8000 & npm run dev
