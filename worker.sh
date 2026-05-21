#!/bin/sh
sleep 8
php bin/console messenger:consume async --memory-limit=128M --time-limit=120