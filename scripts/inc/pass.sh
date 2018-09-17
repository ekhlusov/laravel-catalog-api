#/bin/sh
PASS=$(cat app/.env | grep -oP '^DB_PASSWORD=\K.*')