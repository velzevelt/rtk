<?php

class Pet
{
    public $nickname;
    public $type;
    public $age;
    public $gender;
    public $message = "";
    public $is_hungry = true;

    function __construct($_nickname, $_type, $_age, $_gender, $_message = "")
    {
        $this->nickname = $_nickname;
        $this->type = $_type;
        $this->age = $_age;
        $this->gender = $_gender;
        $this->message = $_message;
    }

    public function say(): void
    {
        $out = $this -> nickname;
        $out .= ($this -> message == "") ? " I can't talk!" : " said: " . $this -> message; 
        echo $out;
    }

    public function feed(): void
    {
        $_is_hungry = &$this->is_hungry;
        $_is_hungry = ($_is_hungry == true) ? false : true;
        echo $_is_hungry ? " I'm hungry" : " I'm not hungry";
    }

    public function starve(): void
    {
        $this->is_hungry = true;
    }
}

$cat = new Pet("Pushock", "Cat", "1", "Male", "Meow");

$cat->say();
var_dump($cat);

$dog = new Pet("Barbos", "Dog", "2", "Male", "Woof");

$dog->say();
var_dump($dog);


$turtle = new Pet("Snejanna", "Turtle", "124", "Female");

$turtle -> say();
var_dump($turtle);

$turtle -> feed();
var_dump($turtle);

$turtle -> starve();
var_dump($turtle);

?>
