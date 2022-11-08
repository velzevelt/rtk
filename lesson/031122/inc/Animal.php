<?php
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