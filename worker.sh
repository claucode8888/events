#!/bin/sh
sleep 8

while true

do

  php bin/console messenger:consume async \
  --memory-limit=128M \
  --time-limit=120 \
  --no-interaction

  sleep 2

done