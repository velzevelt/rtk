<?php 

include_once 'inc/autoload.php';


$cat = new Pet("Borya", "Cat", "1", "Male", "Meow");
echo $cat->say();

var_dump( $cat->feed(1) );
var_dump($cat);

$fish = new Animal(0, '1', 'fish');

var_dump($fish->feed('2'));
var_dump($fish);

echo 'end';

/** Переделать header footer через инклюд */


?>

