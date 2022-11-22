<?php

# Задача 1. Используя рекурсию, реализовать функцию вычисления факториала числа. 

function factrorial(int $n): int
{
    if ($n == 0) {
        return 1;
    }

    if($n > 0) {
        return -1; # Undefined
    }

    if ($n == 1) {
        return 1;
    } else {
        return $n * factrorial($n - 1);
    }
}

# Задача 2. Дан массив вида, который может иметь неограниченную вложенность. Требуется реализовать рекурсивную функцию, которая, на основе данного массива
#   формировала список. Для формирования списка используются теги «<ul></ul><li></li>».

$example = [

    'id' => 1,
    'name' => 'item_1',
    'items' => [

        [
            'id' => 2,
            'name' => 'item_2',
            'items' => [],
        ],

        [
            'id' => 3,
            'name' => 'item_3',
            'items' => [],
        ],

        [
            'id' => 4,
            'name' => 'item_4',
            'items' => [
                [
                    'id' => 5,
                    'name' => 'item_5',
                    'items' => [],
                ],

                [
                    'id' => 6,
                    'name' => 'item_6',
                    'items' => [],
                ],

            ]
        ],

        [
            'id' => 7,
            'name' => 'item_7',
            'items' => [],
        ],


    ],

];

# ul - unordered list
# li - list item

function make_list(array $from): string
{
    $res = "<ul>" . "<li>" . $from['name'] . "</li>" . "</ul>";

    for ($i = 0; $i < count($from['items']); $i++) {
        $res .= "<ul>" . make_list($from['items'][$i]) . "</ul>";
    }

    return $res;
}


echo make_list($example);
