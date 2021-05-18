FROM php:7.4.3-apache
RUN apt-get update && apt-get upgrade -y
RUN docker-php-ext-install mysqli
RUN chmod 777 images && chmod 777 includes
EXPOSE 80
