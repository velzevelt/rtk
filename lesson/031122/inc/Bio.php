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