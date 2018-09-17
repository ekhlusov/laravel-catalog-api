#!/bin/sh
docker exec -i $(docker-compose ps | grep _php_ | cut -d" " -f 1) sh -c "php artisan schedule:run"
