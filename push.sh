#!/bin/bash

STANDART_MESSAGE="upd"


if [ -n "$1" ]
then
    git add .
    git commit -m $1
    git push

else
    echo "Не было задано сообщение коммита"
    echo "Использовано стандартное сообщение $STANDART_MESSAGE"
    git add .
    git commit -m $STANDART_MESSAGE
    git push
fi