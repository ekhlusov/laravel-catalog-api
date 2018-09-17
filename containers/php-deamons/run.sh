#!/bin/sh

# выпиливаем тот хост что там есть ожидаем 10 сек попыток 3 время работы задачи не более 30 минут
/usr/local/bin/php  /app/htdocs/artisan queue:listen --sleep=3 --tries=1500 --timeout=1800