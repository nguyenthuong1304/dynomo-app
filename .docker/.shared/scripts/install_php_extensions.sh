#!/bin/sh

# add wget
apt-get update -yqq && apt-get -f install -yyq wget

# download helper script
# @see https://github.com/mlocati/docker-php-extension-installer/
wget -q -O /usr/local/bin/install-php-extensions https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions \
    || (echo "Failed while downloading php extension installer!"; exit 1)

# install composer
wget https://getcomposer.org/installer -O /tmp/installer && \
  cat /tmp/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
  chmod 744 /usr/local/bin/composer && \
  rm /tmp/installer \

# install extensions
chmod uga+x /usr/local/bin/install-php-extensions && sync && install-php-extensions \
    pdo_mysql pdo_pgsql gd zip redis \
;