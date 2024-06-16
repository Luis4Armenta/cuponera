# Usa la imagen oficial de PHP con Apache
FROM php:8.1-apache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el contenido de tu aplicación al contenedor
COPY app/ /var/www/html/

# Instala extensiones necesarias de PHP (como MySQL)
RUN apt-get update && apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql curl
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 restart

# Exponer el puerto 80
EXPOSE 80
