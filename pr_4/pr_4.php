<?php

# Задача 1. Используя рекурсию, реализовать функцию вычисления факториала числа. 

# 1 return false if undefined

function factrorial($n)
{
    $res = false;
    if (is_int($n) and $n > 0) {

        if ($n == 0 or $n == 1) {
            $res = 1;
        } else {
            $res = $n * factrorial($n - 1);
        }

    }

    return $res;
}

// var_dump(factrorial(4));

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

# list[items] <- list[items] <- list[items] # ul внутри li


function make_list(array $from): string
{
    $res = '';
    $items = $from['items'];

    if ($items != []) { # Есть вложенность

        $res .= '<li>' . $from['name'] . '<ul>';
        foreach ($from['items'] as $item) {
            $res .= make_list($item);
        }
        $res .= '</ul>' . '</li>';

    } else {
        $res .= '<li>' . $from['name'] . '</li>';
    }

    return $res;
}

function make_unordered_list(array $from): string
{
    $res = '<ul>' . make_list($from) . '</ul>';
    return $res;
}

// echo '<ul>' . make_list($example) . '</ul>';
echo make_unordered_list($example);