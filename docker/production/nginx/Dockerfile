# Etapa 1: Construir ativos
FROM debian AS builder

# Instalar o Node.js e construir ferramentas
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    nodejs \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar código da aplicação Laravel
COPY ./public /var/www/public

# Instalar dependências do Node.js e construir ativos
# RUN npm install && npm run build

# Etapa 2: Imagem de produção do Nginx
FROM nginx:alpine

# Copiar configuração personalizada do Nginx
# --------------------------------------------------------------------------
# Substituir a configuração padrão do Nginx pela nossa configuração personalizada
# otimizada para servir uma aplicação Laravel.
# --------------------------------------------------------------------------
COPY ./docker/production/nginx/nginx.conf /etc/nginx/nginx.conf

# Copiar os ativos públicos do Laravel da etapa de construção
# --------------------------------------------------------------------------
# Precisamos apenas do diretório 'public' da nossa aplicação Laravel.
# --------------------------------------------------------------------------
COPY --from=builder /var/www/public /var/www/public

# Definir o diretório de trabalho para a pasta pública
WORKDIR /var/www/public

# Expor a porta 80 e iniciar o Nginx
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
