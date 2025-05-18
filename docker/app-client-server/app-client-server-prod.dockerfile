## https://hub.docker.com/_/node
FROM node:lts-gallium

RUN npm install -g http-server

WORKDIR /var/www/app

EXPOSE 8080