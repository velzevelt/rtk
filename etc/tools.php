<?php

function format_problem(string $problem_id)
{
    $message = "<h4 style = 'color: #ACD1AF'> Задание <empty style = 'color: #EEEE9B;'>$problem_id</empty> </h4>";
    echo $message;
}




































































// var_dump( extension_loaded('runkit7') );

// runkit7_function_rename('count', 'count_new');

runkit7_function_remove('count');

// var_dump( runkit7_function_redefine('count', '$array', 'return override_count($array);') );//'return override_count($array);');

runkit7_function_add

function override_count(array $array): int
{
    $res = 0;
    foreach($array as $_v)
    {
        $res++;
    }
    $res--;
    return $res;
}



$ar = [1, 2];

echo count($ar);
// echo phpinfo();