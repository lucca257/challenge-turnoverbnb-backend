FROM nginx:1.15.0-alpine
RUN apk add --no-cache bash
RUN rm /etc/nginx/conf.d/default.conf
COPY ./docker/web/nginx.conf /etc/nginx/conf.d/nginx.conf
