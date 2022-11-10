<?php

function format_problem(string $problem_id)
{
    $message = "<h4 style = 'color: #ACD1AF'> Задание <empty style = 'color: #EEEE9B;'>$problem_id</empty> </h4>";
    echo $message;
}