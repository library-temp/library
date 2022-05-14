# Update Packages
apt-get update
# Upgrade Packages
apt-get upgrade

# Basic Linux Stuff
apt-get install -y git

# Apache
apt-get install -y apache2

# Enable Apache Mods
a2enmod rewrite

# Install PHP
apt-get install -y php

# PHP Modules
apt-get install -y libapache2-mod-php

# Restart Apache
service apache2 restart

# PHP Modules
apt-get install -y php-pear php-fpm php-dev php-zip php-curl php-xmlrpc php-gd php-mbstring php-xml 

# Set MySQL Pass
debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

# Install MySQL
apt-get install -y mysql-server

# PHP-MYSQL lib
apt-get install -y php-mysql

# Restart Apache
sudo service apache2 restart

#Create database
mysql -uroot -proot -e "create database library;"

#Downloading the schema
apt-get install -y wget 

wget -O schema.sql "https://drive.google.com/uc?export=download&id=1VOYeGIZ_PwdGovzNokSqhboFjRnfyx-D"

#populate data into library database
mysql -uroot -proot library < schema.sql

sudo apt install libapache2-mod-security2 -y

sudo systemctl restart apache2

apt-cache show libapache2-mod-security2
