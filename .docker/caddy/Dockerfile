FROM caddy:2-alpine

ARG APPLICATION_HOSTNAME

RUN apk add --no-cache \
    envsubst

# Configure PHP
COPY conf/Caddyfile.template /opt/Caddyfile.template
RUN envsubst '$$APPLICATION_HOSTNAME' < /opt/Caddyfile.template > /etc/caddy/Caddyfile && \
    rm /opt/Caddyfile.template

WORKDIR /var/www/html

CMD ["caddy", "run", "--config", "/etc/caddy/Caddyfile", "--adapter", "caddyfile"]
