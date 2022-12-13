<?php 
require_once "autoload.php";


/** Задача 1 Реализовать класс, описывающий животное. Класс животного, методы и
свойства определяются самостоятельно студентом. Количество свойств: не менее 5
Количество методов: не менее 7 Проверить работу методов, создав объект класса и
вызвав его методы. */




$fox = new Fox();


// echo $fox->run() . "<br>";
// echo $fox->run();

echo $fox -> nap() . "<br>";
echo $fox -> say() . "<br>";
echo $fox -> hunt() . "<br>";
echo $fox -> eat() . "<br>";
echo $fox -> run() . "<br>";
echo $fox -> breathe() . "<br>";
echo $fox -> addArms() . "<br>";
echo $fox -> getAmountOfLimbs() . "<br>";
