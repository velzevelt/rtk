<?php

// Индексированный массив - ключи - числа

// $ar = [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 20 => 15 ];

// // print_r($ar);

// $ar[] = 10;
// var_dump($ar);

// $ar[10] = 20;
// $ar[20] = 25;
// $ar[] = 100;
// $ar[150] = 60;
// $ar[] = 100;
// $ar[130] = "text";
// $ar[] = true;
// $ar[] = false;
// $ar[] = 1.1;
// $ar[] = null;

// var_dump($ar);


// Ассоциативный массив - все ключи - строки

// $user = [  
//     'name' => "Вася",
//     'surname' => "Пупкин",
//     'age' => 25,
//     'login' => 'vasya-iv2-22',
//     'password' => null,
//     'phone' => "+88003553535",
//     'balance' => null,
//     'salary' => false,

// ];

// var_dump($user);

// Смешанный массив - ключи могут быть и строками и числами

// $user = [  
//     'name' => "Вася",
//     '0' => "Вася",

//     'surname' => "Пупкин",
//     '1' => "Пупкин",

//     'age' => 25,
//     '2' => 25,

//     'login' => 'vasya-iv2-22',
//     '3' => 'vasya-iv2-22',

//     // Etc.
//     'password' => null,
//     'phone' => "+88003553535",
//     'balance' => null,
//     'salary' => false,

// ];

// var_dump($user);


// Многомерный тассив - матрица

// $tanya = [  
//     'name' => "Таня",
//     'surname' => "Иванова",
//     'age' => 25,
//     'login' => 'tanya-iv2-22',
//     'password' => null,
//     'phone' => "+88003553533",
//     'balance' => null,
//     'salary' => false,
// ];


// $user = [  
//     'name' => "Вася",
//     'surname' => "Пупкин",
//     'age' => 25,
//     'login' => 'vasya-iv2-22',
//     'password' => null,
//     'phone' => "+88003553535",
//     'balance' => null,
//     'salary' => false,
//     'friends' => [ $tanya ],

// ];

// var_dump($user);

// echo $user["friends"][0]["name"];

// $b = $a = 10;

// var_dump($a, $b);

// $a += 20;
// $b += 30;

// var_dump($a, $b);

// Ссылки

// $a = 10;
// $b = &$a;
// $c = &$b;

// // var_dump($a, $b, $c);

// $a += 20;
// $b += 30;
// $c /= 5;

// var_dump($a, $b, $c);

// unset($b);
// $c += 5;

// var_dump($a, $b, $c);


$ar = [ 1 => 1, 2 => 2, 3 => 3 ];

var_dump($ar);


foreach( $ar as $key => &$element )
{
    $element += 10;
    echo "$key => " . $element . "<br>";
}

unset($element);

var_dump($ar, $element);
var_dump( count($ar) );

// foreach( $user as $key => $element )
// {
//     echo "$key = " . $element . "<br>";
// }

?>
