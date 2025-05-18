## https://hub.docker.com/_/ubuntu
FROM ubuntu:22.04

## Configuração do Timezone
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y cron vim htop zip git wget curl supervisor postgresql-client postgis nginx && \
    apt-get install -y php8.1-dev php8.1-bcmath php8.1-cli php8.1-gd php8.1-common php8.1-curl php8.1-fpm php8.1-intl php8.1-zip php8.1-mbstring php8.1-mysql php8.1-opcache php8.1-pgsql php8.1-readline php8.1-sqlite3 php8.1-xml && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

ADD ./docker/api-server/php-cli.ini /etc/php/8.1/cli/php.ini
ADD ./docker/api-server/php-fpm.ini /etc/php/8.1/fpm/php.ini





# ## Configura o cronjob
# RUN echo "* * * * * $EQTLINFO_USUARIO cd /var/www/app && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab
# RUN echo "0 * * * * root cd /var/www/app && chmod -R 777 storage/*" >> /etc/crontab
# RUN systemctl enable cron


ADD ./docker/api-server/api-worker.conf /etc/supervisor/conf.d/api-worker.conf
RUN systemctl enable supervisor

RUN echo "daemon off;" >> /etc/nginx/nginx.conf
ADD ./docker/api-server/api-server.conf /etc/nginx/sites-enabled/default
RUN systemctl enable nginx
WORKDIR /var/www/app


EXPOSE 80

