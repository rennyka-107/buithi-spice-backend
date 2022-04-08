FROM nginx:stable-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system asus
RUN adduser -G asus --system -D -s /bin/sh -u ${UID} asus
RUN sed -i "s/user  nginx/user asus/g" /etc/nginx/nginx.conf

ADD ./nginx/default.conf /etc/nginx/conf.d/
# ADD ./nginx/tachyon107_com_certificate.crt /etc/nginx/conf.d/
# ADD ./nginx/tachyon107_com_privkey.key /etc/nginx/

RUN mkdir -p /var/www/html
RUN chown -R asus:asus /var/www/html
