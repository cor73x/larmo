FROM debian:jessie
MAINTAINER Marcin Wójcik <mwojcik@future-processing.com>

ENV DEBIAN_FRONTEND noninteractive

# Install base packages
RUN apt-get update && \
    apt-get -yq --no-install-recommends  install \
        curl \
        apache2 \
        libapache2-mod-php5 \
        php5-mongo \
        php5-curl \
     && apt-get purge -y --auto-remove \
     && rm -rf /var/lib/apt/lists/*

RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
COPY larmo-hub.conf /etc/apache2/sites-available/larmo-hub.conf
RUN a2enconf fqdn && a2enmod rewrite && a2dissite 000-default.conf && a2ensite larmo-hub

EXPOSE 80

CMD ["apache2ctl", "-DFOREGROUND"]