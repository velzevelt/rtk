<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Практическая 1</title>
</head>
<body style = "background-color: black">

<h1 style = "color:white; text-align: center">Практическая работа 1</h1>
<h2 style = "color:white; text-align: center">"Работа со строками"</h2>

<pre style = "font-size: 18px; font-family: Arial; color:white; white-space: nowrap"> 
<?php

require_once "../etc/tools.php";

//  Задание 1.1 Дана строка «php». Сделайте из нее строку «PHP»

// Решение
format_problem(1.1);

$var = 'php';
$var = strtoupper($var);
echo $var;

//


// Задача 1.2. Дана строка «PHP». Сделайте из нее строку «php».

// Решение
format_problem(1.2);

$var = "PHP";
$var = strtolower($var);
echo $var;

// 


// Задача 1.3. Дана строка «london». Сделайте из нее строку «London».

// Решение
format_problem(1.3);

$var = "london";
$var = ucfirst($var);
echo $var;

//


/** Задача 1.5. Дана строка «london is the capital of great britain». 
*   Сделайте из нее строку «London Is The Capital Of Great Britain» 
*/

// Решение
format_problem(1.5);

$var = "london is the capital of great britain";
$var = ucwords($var);
echo $var;

//


// Задача 1.6. Дана строка «LONDON». Сделайте из нее строку «London».

// Решение
format_problem(1.6);

$var = "LONDON";
$var = strtolower($var);
$var = ucfirst($var);
echo $var;

//


/** Задача 2.1. Дана переменная $password, в которой хранится пароль пользователя.
*   Если количество символов пароля больше 5-ти и меньше 10-ти, то выведите пользователю
*   сообщение о том, что пароль подходит, иначе сообщение о том, что нужно придумать
*   другой пароль. 
*
*/

// Решение
format_problem(2.1);

$password = "adad";
$password_length = strlen($password);

// echo ( $password_length > 5 && $password_length < 10 ) ? "пароль подходит" : ( $password_length >= 10 ? "пароль слишком длинный" : "пароль слишком короткий");

echo  $password_length < 5 ? "пароль слишком короткий"  : ( $password_length >= 10 ? "пароль слишком длинный" : "пароль подходит" );

echo 'jhfgjhgjhgjhg';
// 


/** Задача 3.1. Дана строка «html css php». Вырежьте из нее и выведите на экран слово
 *  «html', слово «css» и слово «php». 
 * 
*/

// Решение
format_problem(3.1);

$phrase = "html css php";

$var = substr($phrase, 0, 4); // -> html
echo $var . "<br>";

$var = substr($phrase, 5, 3); // -> css
echo $var . "<br>";

$var = substr($phrase, 9, 3); // -> php
echo $var . "<br>";



//


// Задача 3.2. Дана строка. Вырежьте и выведите на экран последние 3 символа этой строки.

// Решение
format_problem(3.2);

$phrase = "html css php";
$var = substr($phrase, -3, 3);
echo $var;

//


/** Задача 3.3. Дана строка. Проверьте, что она начинается на «http://». Если это так,
выведите «да', если не так - «нет». */

// Решение
format_problem(3.3);

$var = "http://boots_and_cats.com";
echo ( substr($var, 0, 7) == "http://" ) ? "да" : "нет";



//


/** Задача 3.4. Дана строка. Проверьте, что она начинается на «http://» или на «https://».
Если это так, выведите «да', если не так - «нет». */

// Решение
format_problem(3.4);

$var = "https://boots_and_cats.com";
echo ( substr($var, 0, 7) == "http://" or substr($var, 0, 8) == "https://" ) ? "да" : "нет";


//


/** Задача 3.5. Дана строка. Проверьте, что она заканчивается на «.png». Если это так,
выведите «да', если не так - «нет». */

// Решение
format_problem(3.5);

$var = "./ocean/octopus.png";
echo ( substr($var, -4, 4) == ".png" ) ? "да" : "нет";


// 


/** Задача 3.6. Дана строка. Проверьте, что она заканчивается на «.png» или на «.jpg».
Если это так, выведите «да', если не так - «нет» */

// Решение
format_problem(3.6);


$var = "./ocean/octopus.jpg";
echo ( substr($var, -4, 4) == ".png" or substr($var, -4, 4) == ".jpg" ) ? "да" : "нет";


// 


/** Задача 3.7. Дана строка. Если в этой строке более 5-ти символов - вырежьте из нее
первые 5 символов, добавьте троеточие в конец и выведите на экран. Если же в этой
строке 5 и менее символов - просто выведите эту строку на экран. */

// Решение
format_problem(3.7);


$string = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam iste, eveniet reprehenderit cum tempore ipsam suscipit quos laboriosam? Quam, dolor natus. At sint atque odio quos sapiente quia animi voluptas.";
$string_length = strlen($string);
$var = null;

if($string_length > 5)
{
    $var = substr($string, 0, 5);
    $var .= "...";
}
else
{
    $var = $string;
}

echo $var;

//


// Задача 4.1. Дана строка «31.12.2022». Замените все точки на дефисы

// Решение
format_problem(4.1);


$var = "31.12.2022";
$var = str_replace(".", "-", $var);
echo $var;

//


/** Задача 4.2. Дана строка «She looked again at the calendar». Замените в ней все буквы
«a» на цифру 1, буквы «e» - на 2, а буквы «n» - на 3. */

// Решение
format_problem(4.2);


$var = "She looked again at the calendar";
$to_replace = ["a", "e", "n"];
$replacement = ["1", "2", "3"];

$var = str_replace($to_replace, $replacement, $var);

echo $var;

//


/** Задача 4.3. Дана строка с буквами и цифрами, например, «1a2b3c4b5d6e7f8g9h0».
Удалите из нее все цифры. То есть в нашем случае должна получится строка «abcbdefgh». */

// Решение
format_problem(4.3);

$var = "1a2b3c4b5d6e7f8g9h0";
$numbers = range(0, 9);

$var = str_replace($numbers, "", $var);

echo $var;

// 


/** Задача 5.1. Дана строка «She looked again at the calendar». Замените в ней все буквы
«a» на цифру 1, буквы «e» - на 2, а буквы «n» - на 3. */

// Решение
format_problem(5.1);


$var = "She looked again at the calendar";
$replacement = [ "a" => 1, "e" => 2, "n" => 3 ];

$var = strtr($var, $replacement);

echo $var;

//


/** Задача 6.1. Дана строка «the password cannot be empty». Вырежите из нее подстроку
с 3-го символа (отсчет с нуля), 5 штук и вместо нее вставьте «!!!». */

// Решение
format_problem(6.1);

$var = "the password cannot be empty";
$var = substr_replace($var, "!!!", 4, 5);

echo $var;

// P.S. не понял условия задачи


/** Задача 7.1. Дана строка «abc abc abc». Определите позицию первой буквы «b» */

// Решение
format_problem(7.1);

$var = "abc abc abc";
$var = strpos($var, "b");

echo $var;

//


/** Задача 7.2. Дана строка «abc abc abc». Определите позицию последней буквы «b». */

// Решение
format_problem(7.2);

$var = "abc abc abc";
$var = strrpos($var, "b");

echo $var;

//


/** Задача 7.3. Дана строка «abc abc abc». Определите позицию первой найденной
буквы «b', если начать поиск не с начала строки, а с позиции 3. */

// Решение
format_problem(7.3);

$var = "abc abc abc";
$var = strpos($var, "b", 3);

echo $var;

//


/** Задача 7.4. Дана строка «aaa aaa aaa aaa aaa». Определите позицию второго пробела */

// Решение

format_problem(7.4);

$var = "aaa aaa aaa aaa aaa";
$var = strpos($var, " ", strpos($var, " ") + 1);

echo $var;

//




/** Задача 7.5. Проверьте, что в строке есть две точки подряд. Если это так - выведите
«есть', если не так - «нет». */

// Решение
format_problem(7.5);
$var = ".. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Commodi inventore voluptates adipisci repellendus earum. Voluptatibus optio, nobis sint fugit laudantium corrupti error beatae et, velit quibusdam quas distinctio nemo vitae.";

// echo str_contains($var, "..") ? "есть" : "нет";
echo strpos($var, "..") !== false ? "есть" : "нет";




/** Задача 7.6. Проверьте, что строка начинается на «http://». Если это так - выведите
«да', если не так - «нет». */

// Решение
format_problem(7.6);

$var = "http://boots_and_cats.com";
echo strpos($var, "http://") == 0 ? "да" : "нет";



//


/** Задача 8.1. Дана строка. Очистите ее от концевых пробелов. */

// Решение
format_problem(8.1);

$var = " wet water ";
$var = trim($var);

echo $var;

//


/** Задача 8.2. Дана строка «/php/». Сделайте из нее строку «php», удалив концевые
слеши */

// Решение
format_problem(8.2);

$var = "/php/";
$var = trim($var, "/");

echo $var;

//


/** Задача 8.3. Дана строка «слова слова слова.». В конце этой строки может быть
точка, а может и не быть. Сделайте так, чтобы в конце этой строки гарантировано стояла
точка. То есть: если этой точки нет - ее надо добавить, а если есть - ничего не делать.
Задачу решите через rtrim без всяких ифов. */

// Решение
format_problem(8.3);

$var = "слова слова слова.......";
$var = rtrim($var, ".");
$var .= ".";

echo $var;

//


/** Задача 9.1. Дана строка «12345». Сделайте из нее строку «54321». */

// Решение
format_problem(9.1);

$var = "12345";
$var = strrev($var);

echo $var;

//


/** Задача 9.2. Проверьте, является ли слово палиндромом (одинаково читается во всех
направлениях, примеры таких слов: madam, otto, kayak, nun, level) */

// Решение
format_problem(9.2);

$var = "madam";
$rvar = strrev($var);

echo ( $var == $rvar ) ? "слово {$var} - палиндром" : "{$var} - простое слово";



//


/** Задача 10.1. Дана строка «the password cannot be empty». Перемешайте символы
этой строки в случайном порядке. */

// Решение
format_problem(10.1);

$var = "the password cannot be empty";
$var = str_shuffle($var);

echo $var;

//


/** Задача 11.1. Дана строка «12345678». Сделайте из нее строку «12 345 678». */

// Решение

format_problem(11.1);


$var = "12345678";
$var = number_format($var, 0, ".", " ");

echo $var;

//


/** Задача 12.1. Дана строка «html, <b>php</b>, js». Удалите теги из этой строки. */

// Решение
format_problem(12.1);

$var = "html, <b>php</b>, js";
$var = strip_tags($var);

echo $var;

//


/** Задача 12.2. Дана строка «<div><span>the <a>password</a></span> cannot
<b><i>be</i></b> <strong>empty</strong></div>». Удалите все теги из этой строки, кроме
тегов <b> и <i>. */

// Решение

format_problem(12.2);

$var = "<div><span>the <a>password</a></span> cannot <b><i>be</i></b> <strong>empty</strong></div>";

$var = strip_tags($var, [ "<b>", "<i>" ]);

echo $var;

//


/** Задача 12.3. Дана строка «html, <b>php</b>, js». Выведите ее на экран «как есть': то
есть браузер не должен преобразовать <b> в жирный. */

// Решение
format_problem(12.3);

$var = "html, <b>php</b>, js";
$var = htmlspecialchars($var);

echo $var;

//


/** Задача 13.1. Узнайте код символов «a', «b', «c', пробела */

// Решение
format_problem(13.1);

$chars = [ 'a', 'b', 'c', ' ' ];

foreach($chars as $char)
{
    $id = ord($char);
    echo "$char " . $id . "<br>";
}



//


/** Задача 13.2. Изучите таблицу ASCII. Определите границы, в которых
располагаются буквы английского алфавита */

// Решение
format_problem(13.2);

$alphabete = array_merge(range('A', 'Z'), range('a', 'z'));
$first_letter = $alphabete[0];
$last_letter = end($alphabete);

echo "английский алфавит начинается с " . ord($first_letter) . "<br>";
echo "английский алфавит кончается на " . ord($last_letter);


//


/** Задача 13.3. Выведите на экран символ с кодом 33. */

// Решение
format_problem(13.3);

echo chr(33);

//


/** Задача 13.4. Запишите в переменную $str случайный символ - большую букву
латинского алфавита. Подсказка: с помощью таблицы ASCII определите какие целые
числа соответствуют большим буквам латинского алфавита. */

// Решение
format_problem(13.4);

$bounds = range('A', 'Z');
$str = $bounds[ rand(0, count($bounds) - 1 ) ];

echo $str;

//


/** Задача 13.6. Дана буква английского алфавита «f». Узнайте, она маленькая или
большая. Выведите букву и результат на экран. */

// Решение
format_problem(13.6);

$letter = "f";

echo ctype_lower($letter) ? "$letter буква маленькая" : "$letter буква большая";



//


/** Задача 14.1. Дана строка «ab-cd-ef». С помощью функции strchr выведите на экран
строку «-cd-ef». */

// Решение
format_problem(14.1);

$var = "ab-cd-ef";
$search_var = "-cd-ef";

$var = strchr($var, $search_var);

echo $var;

//


/** Задача 14.2. Дана строка «ab-cd-ef». С помощью функции strrchr выведите на экран
строку «-ef». Показать решение */

// Решение
format_problem(14.2);

$var = "ab-cd-ef";
$search_var = "-ef";

$var = strrchr($var, $search_var);

echo $var;


//


/** Задача 15.1. Дана строка «ab--cd--ef». С помощью функции strstr выведите на экран
строку «--cd--ef». */

// Решение
format_problem(15.1);

$var = "ab--cd--ef";
$var = strstr($var ,"--cd--ef");

echo $var;

//


/** Дополнительная задача:
1. Преобразуйте строку «var_test_text» в «varTestText». Скрипт, конечно же, должен
работать с любыми аналогичными строками. */

// Решение
format_problem("Дополнительное");

$var = "var_test_text";
$var = str_to_pascal_case($var);

echo $var;

function str_to_pascal_case(string $arg)
{
    $arg = str_replace("_", " ", $arg); // -> var test text
    $arg = ucwords($arg); // -> Var Test Text
    $arg = lcfirst($arg); // -> var Test Text
    $arg = str_replace(" ", "", $arg); // -> varTestText
    return $arg;
}

//

?>
</pre>

</body>
</html>