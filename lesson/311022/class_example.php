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
    
    function __construct($_age, $_gender, $_type)
    {
        parent::__construct($_age, $_gender);
        $this -> type = $_type;
    }

    public function feed($food): string
    {
        $this->hungry = false;
        return $this->hungry;
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

class Pet extends Animal
{
    public $nickname;
    public $message = "";

    function __construct($_nickname, $_type, $_age, $_gender, $_message = "")
    {
        parent::__construct($_age, $_gender, $_type);
        $this->nickname = $_nickname;
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

    public function feed($food): string
    {   
        $res = " not hungry";
        if($this->hungry)
        {
            parent::feed($food);
            $res = " ate " . $food; 
        }
        return $this->nickname . $res;
    }

}

$cat = new Pet("Borya", "Cat", "1", "Male", "Meow");


echo $cat->say();

var_dump( $cat->feed(1) );
var_dump($cat);

$fish = new Animal(0, '1', 'fish');

var_dump($fish->feed('2'));
var_dump($fish);

?>
