#!/bin/bash

# REQUIRES ELEVATED ACCESS!! Execute this in sudo mode

# setup for incorrect charsets
apt-get install -y software-properties-common python-software-properties language-pack-en-base
LC_ALL=en_US.UTF-8
# adding repositories
add-apt-repository ppa:ondrej/php
curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
# updating
echo "Updating repositories"
apt-get update
# install php 7
echo "Installing PHP 7 CLI"
apt-get install -y php7.0 php7.0-gd php7.0-mbstring php7.0-sqlite php7.0-mysql
echo "Installing NodeJS"
apt-get install -y nodejs
echo "Installing Bower"
npm install -g bower
echo "Installing required softwares.."
sudo apt-get install php libapache2-mod-php
sudo a2dismod php5
sudo a2enmod php7.0
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
