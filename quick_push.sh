#!/bin/bash

if [ -n "$1" ]
then
    git add .;
    git commit -m $1;
    git push;

else
    echo 'Не было задано сообщение коммита';
    echo 'Использовано стандартное сообщение "upd"';
    git add .;
    git commit -m "upd";
    git push;
fi