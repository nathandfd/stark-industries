#!/usr/bin/env sh
/composer/composer.phar install
npm install
npm install -D tailwindcss@latest postcss@latest autoprefixer@latest
npm run build
php bin/console d:s:u -f
php bin/console c:c
apachectl -D FOREGROUND