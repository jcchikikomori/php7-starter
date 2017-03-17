#!/bin/bash

# REQUIRES ELEVATED ACCESS!! Execute this in sudo mode

# fixing annoying git config permissions
chown $USER.$GROUP -R /home/$USER/.config
# updating
apt-get update
# setup for incorrect charsets
apt-get install -y software-properties-common python-software-properties language-pack-en-base
echo "Updating Composer"
composer self-update
LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php
curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
echo "Installing NodeJS"
apt-get install -y nodejs
echo "Installing Bower"
npm install -g bower
# install php 7
echo "Installing PHP 7 CLI"
apt-get install -y php7.0
echo "Installing MyPHP"
composer self-update
echo "Please manually install vendors by command 'composer install' ..."
bower install --allow-root
echo "Disabling PHP5 on server"
a2dismod php5
echo "Installing required softwares.."
apt-get install -y php php7.0-gd php7.0-mbstring php7.0-sqlite php7.0-mysql libapache2-mod-php
echo "Activating PHP7 on server"
a2enmod php7.0
# restarting server
service apache2 restart
# finishes
echo ""
echo ""
echo ""
echo "You are now using the following on you server!"
php -v
echo ""
node -v
bower -v
echo ""
echo "Installation done!"
