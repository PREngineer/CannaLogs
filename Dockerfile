# Use the PHP 7.4 image using Apache
FROM php:7.4-apache

# Labels
LABEL maintainer="Jorge Pabon <pianistapr@hotmail.com>"


# Update the system
RUN apt-get update && apt upgrade -y

# Install additional extensions for PHP
RUN docker-php-ext-install pdo mysqli pdo_mysql 

# Enable the extensions
RUN docker-php-ext-enable mysqli pdo_mysql

# Copy the contents of the application to the container
ADD ./CannaLogs /var/www

# Copy the site configuration to Apache
COPY ./CannaLogs.conf /etc/apache2/sites-available/CannaLogs.conf

# Enable mods
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf &&\
    a2enmod rewrite &&\
    a2enmod headers &&\
    a2enmod rewrite &&\
    a2dissite 000-default &&\
    a2ensite CannaLogs &&\
    service apache2 restart

# Listen on port
EXPOSE 80