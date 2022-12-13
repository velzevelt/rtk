<?php

class Fox
{
    public $gender;
    public $nickname;
    public $amountOfLegs;
    public $amountOfArms;
    public $amountOfHeads;
    public $amountOfFingers;
    public $energy = 30;

    
    function __construct($_gender = "Female", $_nickname = "Kitsune", $_amountOfLegs = 4, $_amountOfArms = 0, $_amountOfHeads = 1, $_amountOfFingers = 10)
    {
        $this->gender = $_gender;
        $this->nickname = $_nickname;
        $this->amountOfLegs = $_amountOfLegs;
        $this->amountOfArms = $_amountOfArms;
        $this->amountOfHeads = $_amountOfHeads;
        $this->amountOfFingers = $_amountOfFingers;
    }

    public function say($text = "Агу-агу"): string
    {
        return $text;
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

    public function breathe(): string
    {
        return "Я дышу";
    }

    public function eat(): string
    {
        return "Я ем";
    }

    public function hunt(): string
    {
        return "Я охочусь";
    }
    public function run(int $cost = 20): string
    {
        $r = '';
        while($this->energy < $cost) {
            $r .= $this->nap() . "<br>";
        }
        $r .= "Я бегу";
        $this->energy -= $cost;
        return $r;
    }

    public function nap(int $rest_percent = 30): string 
    {
        # Clamp min=0 max=100
        $rest_percent = $rest_percent < 0 ? 0 : $rest_percent;
        $rest_percent = $rest_percent > 100 ? 100 : $rest_percent;

        $this->energy += ($this->energy / 100) * $rest_percent;

        return "Я сплю";
    }

}