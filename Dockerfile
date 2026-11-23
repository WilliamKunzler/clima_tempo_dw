FROM php:8.3-apache

# Extensão PDO para MySQL/MariaDB
RUN docker-php-ext-install pdo_mysql
