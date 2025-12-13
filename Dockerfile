# ----------------------------------------------------
# ETAPA 1: BUILD (Compilación de Assets de Frontend)
# ----------------------------------------------------
FROM node:18 as node_builder

# Instalar Git para que las descargas de Composer funcionen si fueran necesarias, aunque Composer se moverá a la etapa 2
RUN apt-get update && apt-get install -y git

# Establecer el directorio de trabajo para esta etapa
WORKDIR /app

# Copiar archivos de Node
COPY package.json package-lock.json ./
# El composer.json se copia para la etapa 2

# Instalar dependencias de Node
RUN npm install

# Copiar el código fuente completo
COPY . .

# Compilar los assets de Frontend
RUN npm run build


# ----------------------------------------------------
# ETAPA 2: PRODUCCIÓN (Entorno de Ejecución PHP/FPM)
# ----------------------------------------------------
# Cambia '8.2' por la versión de PHP que realmente usa tu proyecto
FROM php:8.2-fpm-bullseye as final_production

# INSTALACIÓN EXPLÍCITA DE COMPOSER (¡NUEVO BLOQUE DE CÓDIGO!)
# Esto asegura que el comando 'composer' esté disponible en esta imagen.
RUN apt-get update && apt-get install -y wget
RUN wget https://getcomposer.org/installer -O composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# 1. INSTALACIÓN DE DEPENDENCIAS DEL SISTEMA (SOLUCIÓN PDFTOTEXT)
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    # ESTO ES LO CRUCIAL PARA PDFTOTEXT
    poppler-utils \
    # Instalar librerías para extensiones de PHP
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && rm -rf /var/lib/apt/lists/*

# 2. INSTALACIÓN DE EXTENSIONES DE PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# 3. DIRECTORIO DE TRABAJO
WORKDIR /var/www/html

# 4. COPIAR ARCHIVOS DE CÓDIGO Y COMPOSER
# Copiar archivos de Composer (necesarios para el siguiente paso)
COPY composer.json composer.lock ./
# Copiar el resto del código y el frontend compilado
COPY --from=node_builder /app/public public
COPY --from=node_builder /app .

# 5. INSTALACIÓN DE DEPENDENCIAS DE PHP (NUEVA UBICACIÓN)
RUN composer install --no-dev --optimize-autoloader

# 6. OPTIMIZACIONES DE LARAVEL (PARA PRODUCCIÓN)
# RUN DB_CONNECTION=mysql php artisan config:cache
# RUN DB_CONNECTION=mysql php artisan route:cache
# RUN DB_CONNECTION=mysql php artisan view:cache

# 7. CONFIGURACIÓN DE PERMISOS (CRUCIAL PARA LARAVEL)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. LIMPIEZA FINAL
# Forzamos la conexión de DB y el CACHE_DRIVER a 'file' para evitar 
# el fallo de SQLite durante el build.

# Limpiamos la configuración (DB_CONNECTION=mysql para evitar el fallo anterior)
# RUN DB_CONNECTION=mysql php artisan config:clear

# Limpiamos la caché de la aplicación forzando el driver a 'file'
# RUN CACHE_DRIVER=file php artisan cache:clear

# Limpiamos la caché de vistas
# RUN php artisan view:clear

# 9. COMANDO DE INICIO
# CMD ["php-fpm"]