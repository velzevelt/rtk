<?php

class Bio
{
    public $age;
    public $gender;

    function __construct($_age, $_gender)
    {
        $this->age = $_age;
        $this->gender = $_gender;
    }
}

class Animal extends Bio
{
    public $type;
    public $hungry = true;
    
    function __construct($_type, $_age, $_gender)
    {
        $this -> gender = $_gender;
        $this -> type = $_type;
        $this -> age = $_age;
    }
    
}

class Pet extends Animal
{
    public $nickname;
    public $message = "";

    function __construct($_nickname, $_type, $_age, $_gender, $_message = "")
    {
        $this->nickname = $_nickname;
        $this->type = $_type;
        $this->age = $_age;
        $this->gender = $_gender;
        $this->message = $_message;
    }

    function __destruct()
    {
        echo $this->nickname . " died" . "<br>";
    }

    public function say(): string
    {
        $out = $this -> nickname;
        $out .= ($this -> message == "") ? " I can't talk!" : " said: " . $this -> message; 
        return $out;
    }

    public function feed(): void
    {
        $this->hungry = false;
    }

    public function starve(): void
    {
        $this->hungry = true;
    }

    public function is_hungry(): string
    {
        $out = $this -> nickname;
        $out .= " ";
        $out .= $this -> hungry ? "I'm hungry" : "I'm not hungry";
        return $out;
    }
}

// $cat = new Pet("Pushock", "Cat", "1", "Male", "Meow");


echo $cat->say();
var_dump($cat);


?>
