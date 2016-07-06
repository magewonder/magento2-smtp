# Getting Started
Configure Magento 2 to use custom SMTP server to send email

# Features
* Sendgrid

# How to install extension

Backup your store database and web directory.

Enable extension.
php -f bin/magento module:enable MageWonder_Smtp

Upgrade system
php -f bin/magento setup:upgrade

Clean cache
php -f bin/magento cache:clean

Deploy static view files
rm -rf pub/static/*; rm -rf var/view_preprocessed/*; php -f bin/magento setup:static-content:deploy
