# Etapa 1: ambiente de construção e dependências do Composer
FROM php:8.3-fpm AS builder

# Instalar dependências do sistema e extensões PHP necessárias para suporte ao Laravel + MySQL/PostgreSQL
# Algumas dependências são necessárias para extensões PHP apenas na fase de compilação
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    opcache \
    intl \
    zip \
    bcmath \
    soap \
    # && pecl install redis
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure gd --with-jpeg --with-webp --with-xpm

# RUN docker-php-ext-enable redis \
#     && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
RUN apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Defina o diretório de trabalho dentro do contêiner
WORKDIR /var/www

# Copie todo o código da aplicação Laravel para o contêiner
# -----------------------------------------------------------
# No Laravel, o comando `composer install` frequentemente aciona
# scripts que precisam de acesso a todo o código da aplicação.
# Por exemplo, o evento `post-autoload-dump` pode executar
# comandos do Artisan como `php artisan package:discover`. Se o
# código da aplicação (incluindo o arquivo `artisan`) não estiver
# presente, esses comandos falharão, levando a erros de compilação.
#
# Ao copiar todo o código da aplicação antes de executar
# `composer install`, garantimos que todos os arquivos necessários estejam
# disponíveis, permitindo que esses scripts sejam executados com sucesso.
# Em outros casos, seria possível copiar os arquivos do composer
# primeiro, para aproveitar o mecanismo de cache de camadas do Docker.
# -----------------------------------------------------------
COPY . /var/www

# Instalar o Composer e dependências
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
#     && composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist

# RUN rm /var/www/composer.json \
#     /var/www/composer.lock




# Etapa 2: Ambiente de produção
FROM php:8.3-fpm AS production

LABEL maintainer="ATI <contato@ati.ma.gov.br>" \
      version="1.0.0"

# Instalar apenas bibliotecas de tempo de execução necessárias na produção
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    libfcgi-bin \
    procps \
    supervisor \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copie o script de inicialização
COPY ./docker/production/php-fpm/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Copie extensões e bibliotecas PHP do estágio do construtor
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/
COPY --from=builder /usr/local/bin/docker-php-ext-* /usr/local/bin/

# Copie o código do aplicativo e as dependências do estágio de construção
COPY --from=builder /var/www /var/www

# Definir diretório de trabalho
WORKDIR /var/www

# Garanta as permissões corretas
RUN chown -R www-data:www-data /var/www/storage

# Mude para o usuário não privilegiado para executar o aplicativo
# USER www-data

# Altere o comando padrão para executar o script do ponto de entrada
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Exponha a porta 9000 e inicie o servidor php-fpm
EXPOSE 9000
CMD ["php-fpm"]