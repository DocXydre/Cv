FROM wordpress:latest
RUN addgroup -g 82 -S www-data ; \
	usermod -aG www-data www-data && exit 0; exit 1;
COPY custom.ini $PHP_INI_DIR/conf.d/