#!/usr/bin/env sh
/composer/composer.phar install
npm install
npm run build
php bin/console d:s:u -f
php bin/console c:c
apachectl -D FOREGROUND