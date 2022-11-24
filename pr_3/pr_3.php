<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практическая 3</title>
</head>

<body style="background-color: black; color: white">

    <h1 style="color:white; text-align: center"> <b>Практическая работа</b> 3</h1>
    <h2 style="color:white; text-align: center">"Использование пользовательских функций"</h2>

    <pre style="font-size: 22px; font-family: Arial; color:white">
<?php

require_once "../etc/tools.php";


/** 1. Сделайте функцию, которая принимает строку на русском языке, а
возвращает ее транслит */

format_problem(1);

$var = "шиншилла МИР !! ЩУКА Щщука";

echo translit($var);

function translit(string $text): string
{
    $dictionary = [
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "ё" => "yo",
        "ж" => "zh",
        "з" => "z",
        "и" => "i",
        "й" => "j",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "kh",
        "ц" => "ts",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "sch",
        "ъ" => "\"",
        "ы" => "y",
        "ь" => "'",
        "э" => "e",
        "ю" => "yu",
        "я" => "ya",
    ];

    $text = mb_str_split($text);
    $previous = 0;

    foreach ($text as $key => $val) {
        $low_val = mb_strtolower($val);

        if (array_key_exists($val, $dictionary)) {
            $text[$key] = $dictionary[$val];

            if( !array_key_exists($text[$previous], $dictionary) ) { # Предыдущий - Большая? -> Уменьшает следующие
                $first = $text[$previous][0];
                $next = mb_substr($text[$previous], 1);
                $next = mb_strtolower($next);
                $text[$previous] = $first . $next;
            }
        } elseif (array_key_exists($low_val, $dictionary)) {
            $text[$key] = mb_strtoupper($dictionary[$low_val]);
        }
        $previous = $key;
    }


    return join($text);
}



/** 2. Сделайте функцию, которая возвращает множественное или
единственное число существительного. Пример: 1 яблоко, 2 (3, 4)
яблока, 5 яблок. Функция первым параметром принимает число, а
следующие 3 параметра — форма для единственного числа, для чисел
два, три, четыре и для чисел, больших четырех, например, func(3,
'яблоко', 'яблока', 'яблок') */

format_problem(2);

echo str_plural(16, 'яблоко', 'яблока', 'яблок');



function str_plural(int $amount, string $singular, string $two_four, string $plural): string
{
    $result = "";

    switch ($amount) {
        case 0:
            $result = $amount . " " . $plural;
            break;
        case 1:
            $result = $amount . " " . $singular;
            break;
        case $amount >= 2 and $amount <= 4:
            $result = $amount . " " . $two_four;
            break;
        default:
            $result = $amount . " " . $plural;
    }

    return $result;
}


/** 3. Найдите все счастливые билеты. Счастливый билет - это билет, в
котором сумма первых трех цифр его номера равна сумме вторых трех
цифр его номера */


format_problem(3);



/** возвращает количество всех возможных счастливых билетов */
function count_tickets(): int
{
    $count = 0;
    $ticket = [];
    for ($i = 0; $i < 1000000; $i++) {
        for ($k = $i, $j = 0; $j < 6; $j++, $k /= 10) {
            $ticket[$j] = $k % 10;
        }
        if ($ticket[0] + $ticket[1] + $ticket[2] == $ticket[3] + $ticket[4] + $ticket[5]) {
            $count++;
        }
    }
    return $count;
}

/** проверяет, является ли заданный билет счастливым */
function is_lucky(string $ticket): mixed
{
    $result = false;

    if(strlen($ticket) > 6) { # Билет больше шести -> обрезаем до шести
        $ticket = substr($ticket, 0, 6);
    }

    while (strlen($ticket) < 6) { # Билет меньше шести -> добавляем нули в конец
        $ticket .= '0';
    }

    if ($ticket[0] + $ticket[1] + $ticket[2] == $ticket[3] + $ticket[4] + $ticket[5]) {
        $result = $ticket;
    }
    
    return $result;
}


# 1 - 1200
for ($i = 1; $i < 1200; $i++) {
    if( $t = is_lucky($i) ) {
        echo "билет $t - счастливый" . "<br>";
    }
}




/** 4. Дружественные числа - два различных числа, для которых сумма всех
собственных делителей первого числа равна второму числу и наоборот,
сумма всех собственных делителей второго числа равна первому числу.
Например, 220 и 284. Делители для 220 это 1, 2, 4, 5, 10, 11, 20, 22, 44, 55
и 110, сумма делителей равна 284. Делители для 284 это 1, 2, 4, 71 и 142,
их сумма равна 220.
Задача: найдите все пары дружественных чисел в промежутке от 1 до
10000. Для этого сделайте вспомогательную функцию, которая находит
все делители числа и возвращает их в виде массива. Также сделайте
функцию, которая параметром принимает массив, а возвращает его
сумму. */

format_problem(4);



// var_dump(sum(get_divisors(284)));

// var_dump(is_friendly(284, 220));






/** ищет дружественные числа в диапазоне */
function get_friendly_numbers(int $from = 1, int $to = 500): array
{
    $result = [];
    $divisors = [];

    /** считаем делители заранее, так как это дорогая операция */
    for ($x = $from; $x <= $to; $x++) {
        $divisors[$x] = sum(get_divisors($x));
    }

    for ($x = $from; $x <= $to; $x++) {
        for ($y = $from + 1; $y <= $to; $y++) {
            if ($x == $y) {
                continue;
            }

            $sum_1 = $divisors[$x];
            $sum_2 = $divisors[$y];

            if ($sum_1 == $y and $sum_2 == $x) {
                $result[$x] = $y;
            }
        }
    }


    return $result;
}

/** возвращает делители числа, исключая само число */
function get_divisors(int $num): array
{
    $result = [];

    for ($i = 1; $i < $num; $i++) {
        if ($num % $i == 0) {
            array_push($result, $i);
        }
    }

    return $result;
}

function sum(array $ar): int
{
    return array_sum($ar);
}


/** проверяет, являются ли указанные числа дружественными */
function is_friendly(int $a, int $b): bool
{
    $result = false;

    $sum_1 = sum(get_divisors($a));
    $sum_2 = sum(get_divisors($b));

    $result = ($sum_1 == $b and $sum_2 == $a);

    return $result;
}

?>


</pre>

</body>

</html>