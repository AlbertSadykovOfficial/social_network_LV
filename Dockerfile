FROM php:7.3-apache


#Install git
RUN apt-get update \
    && apt-get install -y git


#For php gd library
RUN apt-get install -y \
libfreetype6-dev \
libjpeg62-turbo-dev \
&& docker-php-ext-configure gd \
--with-freetype-dir=/usr/include/freetype2 \
--with-png-dir=/usr/include \
--with-jpeg-dir=/usr/include \
&& docker-php-ext-install gd \
&& docker-php-ext-enable gd


#PHP + MYSQL
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite


#Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=. --filename=composer
RUN mv composer /usr/local/bin/
COPY app/ /var/www/html/
EXPOSE 80
