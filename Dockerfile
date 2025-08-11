FROM php:8.3

RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libonig-dev

# Copia o php.ini da raiz do projeto para o diretório de configuração do PHP no container
# COPY php.ini /usr/local/etc/php/

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala as extensões PDO e mbstring
RUN docker-php-ext-install pdo_mysql mbstring

WORKDIR /app

COPY . /app

# Instala as dependências do Laravel
RUN composer install

# Expor a porta do servidor Laravel
EXPOSE 8000

# Comando para rodar as migrações e iniciar o servidor
CMD php artisan serve --host=0.0.0.0 --port=8000
