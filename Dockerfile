# ----------------------------------------------------
# ETAPA 1: BUILD (Compilación de Assets de Frontend)
# ----------------------------------------------------
FROM node:18 as node_builder

# Instalar Git para que Composer pueda descargar dependencias
RUN apt-get update && apt-get install -y git

# Establecer el directorio de trabajo para esta etapa
WORKDIR /app

# Copiar archivos de Node y Composer para aprovechar la caché
COPY package.json package-lock.json ./
COPY composer.json composer.lock ./

# Instalar dependencias de Node
RUN npm install

# Instalar dependencias de PHP y descargar vendors (solo si Composer necesita Git)
RUN composer install --no-dev --ignore-platform-reqs

# Copiar el código fuente completo
COPY . .

# Compilar los assets de Frontend
RUN npm run build


# ----------------------------------------------------
# ETAPA 2: PRODUCCIÓN (Entorno de Ejecución PHP/FPM)
# ----------------------------------------------------
# Cambia '8.2' por la versión de PHP que realmente usa tu proyecto
FROM php:8.2-fpm-bullseye as final_production

# 1. INSTALACIÓN DE DEPENDENCIAS DEL SISTEMA (SOLUCIÓN PDFTOTEXT)
# Instala poppler-utils y otras extensiones de PHP necesarias
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
    # Limpieza de cache al final
    && rm -rf /var/lib/apt/lists/*

# 2. INSTALACIÓN DE EXTENSIONES DE PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# 3. DIRECTORIO DE TRABAJO
WORKDIR /var/www/html

# 4. COPIAR ARCHIVOS DESDE LAS ETAPAS ANTERIORES
# Copiar el código y los assets compilados desde la etapa 'node_builder'
COPY --from=node_builder /app/public public
COPY --from=node_builder /app/vendor vendor
COPY --from=node_builder /app .
COPY --from=node_builder /app/.env.example ./.env.example # Solo si lo usas

# 5. OPTIMIZACIONES DE LARAVEL (PARA PRODUCCIÓN)
# Creamos archivos de configuración y rutas en caché.
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# 6. CONFIGURACIÓN DE PERMISOS (CRUCIAL PARA LARAVEL)
# Asignar el usuario 'www-data' (bajo el que corre PHP-FPM) como dueño.
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 7. COMANDO DE INICIO
# Inicia PHP-FPM en primer plano
CMD ["php-fpm"]