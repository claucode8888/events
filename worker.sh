#!/bin/sh
sleep 8

first_time=true

while true

do
  if [ "$first_time" = false ]
    then
    echo " ******************************* Restarting worker... ****************************************** "
  fi

  php bin/console messenger:consume async \
  --memory-limit=128M \
  --time-limit=120 \
  --no-interaction

  first_time=false
  sleep 2

done