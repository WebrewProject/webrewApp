#!/bin/sh

php bin/console doctrine:schema:drop --full-database --force 
php bin/console make:migration -y 
php bin/console doctrine:migrations:migrate -y

php bin/console doctrine:fixtures:load