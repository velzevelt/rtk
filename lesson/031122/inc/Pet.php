<?php
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