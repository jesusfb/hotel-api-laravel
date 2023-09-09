RUN addgroup nobody tty

# Install supervisor
RUN apk add --no-cache supervisor
RUN apk add --no-cache py3-pip
RUN pip install supervisor-stdout

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN addgroup -S www && adduser -S www -G www

# Copy code to /var/www
COPY --chown=www:www-data . /var/www

# add root to www group
RUN chmod -R ug+w /var/www/storage

# Copy nginx/php/supervisor configs
RUN cp .docker/supervisord.conf /etc/supervisord.conf
RUN cp .docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp .docker/default.conf /etc/nginx/http.d/default.conf
RUN cp .docker/nginx.conf /etc/nginx/nginx.conf

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

# If you want to install private packages you can add auth token inside composer.
#RUN composer config gitlab-oauth.gitlab.com $composer_auth_token
#RUN composer config gitlab-token.gitlab.org $composer_auth_token
#RUN composer config github-oauth.github.com $composer_auth_token

# In this case you should set ARG for key and secret
#RUN composer config bitbucket-oauth.bitbucket.org consumer-key consumer-secret

# Deployment steps
RUN composer install --optimize-autoloader --no-progress --no-interaction

RUN chmod +x /var/www/.docker/run.sh

RUN chmod o+w /var/www/storage -R

EXPOSE 80/tcp
ENTRYPOINT ["/var/www/.docker/run.sh"]
