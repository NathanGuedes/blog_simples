FROM php:8.4-fpm

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libzip-dev \
    libicu-dev \
    libpng-dev \
    libpq-dev \
    # Adicionada a dependência para o PostgreSQL
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        # Trocado de pdo_mysql para pdo_pgsql
        zip \
        intl \
        gd \
    && rm -rf /var/lib/apt/lists/*

# Instalar Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copiar configuração do Xdebug
COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Instalar Composer (aproveitando imagem oficial pra garantir versão atual)
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar configuração do PHP para usar Redis para sessões
COPY php.ini /usr/local/etc/php/conf.d/sessions.ini