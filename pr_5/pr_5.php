<?php 


/** Задача 1 Реализовать класс, описывающий животное. Класс животного, методы и
свойства определяются самостоятельно студентом. Количество свойств: не менее 5
Количество методов: не менее 7 Проверить работу методов, создав объект класса и
вызвав его методы. */


class Animal
{
    public $gender;
    public $nickname;
    public $amountOfLegs;
    public $amountOfArms;
    public $amountOfHeads;
    public $amountOfFingers;

    
    function __construct($_gender = "Female", $_nickname = "Kitsune", $_amountOfLegs = 4, $_amountOfArms = 0, $_amountOfHeads = 1, $_amountOfFingers = 10)
    {
        $this->gender = $_gender;
        $this->nickname = $_nickname;
        $this->amountOfLegs = $_amountOfLegs;
        $this->amountOfArms = $_amountOfArms;
        $this->amountOfHeads = $_amountOfHeads;
        $this->amountOfFingers = $_amountOfFingers;
    }

    public function say($text = "Агу-агу"): void
    {
        echo $text;
    }

    public function addArms(): int
    {
        $_amountOfArms = &$this -> amountOfArms;
        $_amountOfArms++;
        return $_amountOfArms;
    }

    public function getAmountOfLimbs(): int
    {
        return $this -> amountOfLegs + $this -> amountOfArms;
    }

    public function breathe(): void
    {
        echo "Я дышу";
    }

    public function eat(): void
    {
        echo "Я ем";
    }

    public function hunt(): void
    {
        echo "Я охочусь";
    }

    public function run(): void
    {
        echo "Я бегу";
    }
}

$fox = new Animal();

$fox -> say();
echo "<br>";

$fox -> hunt();
echo "<br>";

$fox -> eat();
echo "<br>";

$fox -> run();
echo "<br>";

$fox -> breathe();
echo "<br>";

echo $fox -> addArms();
echo "<br>";

echo $fox -> getAmountOfLimbs();
echo "<br>";
