FROM ubuntu:20.04 AS base_image
LABEL maintainer="Le Thanh An <anlt@palvietnam.vn>"

#### PHP-FPM + NGINX
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update
RUN yes | apt-get install nginx
RUN yes | apt-get install software-properties-common && add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt-get install -y \
    php8.0-fpm \
    php8.0-cli \
    php8.0-curl \
    php8.0-mysql \
    php8.0-mbstring \
    php8.0-xml \
    php8.0-dev \
    php8.0-redis \
    php8.0-gd \
    php8.0-intl \
    php8.0-xsl \
    php8.0-zip \
    php8.0-imagick
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer && mkdir /run/php 
RUN echo "clear_env = no">>/etc/php/8.0/fpm/pool.d/www.conf
RUN echo "catch_workers_output = yes">>/etc/php/8.0/fpm/pool.d/www.conf
RUN sed -i 's/\/var\/log\/php8.0-fpm.log/\/proc\/self\/fd\/2/g' /etc/php/8.0/fpm/php-fpm.conf

RUN apt-get install -y \
	vim \
    supervisor \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

#### Clear apt-get
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

#### config
#WORKDIR /var/www/
#COPY ./app .
COPY ./nginx/app.conf  /etc/nginx/sites-enabled/default


#### RUNING
EXPOSE 80
COPY ./supervisord/supervisord.conf  /etc/supervisor/conf.d/supervisord.conf
COPY ./initial /usr/local/bin/
RUN chmod +x /usr/local/bin/initial

RUN mkdir -p /var/log/initial
RUN touch /var/log/initial/log
RUN chmod -R 775 /var/log/initial/log
CMD [ "/usr/local/bin/initial"]

