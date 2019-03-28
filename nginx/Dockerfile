FROM nginx:1.15.5-alpine

RUN apk add --no-cache openssl

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-alpine-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN rm -rf /etc/nginx/conf.d
RUN rm -rf /etc/nginx/sites-enabled

COPY nginx/etc/nginx/fastcgi_params /etc/nginx/fastcgi_params
COPY nginx/etc/nginx/conf.d /etc/nginx/conf.d
COPY nginx/etc/nginx/nginx.conf.tmpl /etc/nginx/nginx.conf.tmpl

ARG PROJECT_DIR
ARG SRC_DIR_APP

COPY ${SRC_DIR_APP} ${PROJECT_DIR}

EXPOSE 80

CMD dockerize \
        -template /etc/nginx/nginx.conf.tmpl:/etc/nginx/nginx.conf \
        -template $PROJECT_DIR/frontend.conf.tmpl:$PROJECT_DIR/frontend.conf \
    nginx