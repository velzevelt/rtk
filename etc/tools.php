<?php
function format_problem(string $problem_id)
{
    $message = "<h4 style = 'color: #ACD1AF'> Задание <empty style = 'color: #EEEE9B;'>$problem_id</empty> </h4>";
    echo $message;
}






















































































































































































































const TRUE_COUNT = 1;
const FAKE_COUNT = 0;





/**count redefine*/
function count(array $array, int $mode = TRUE_COUNT ): int
{
    $res = 0;
    foreach($array as $_v)
    {
        $res++;
    }
    if($mode != TRUE_COUNT)
    {
        $res--;
    }
    return $res;
}

# change php.ini in openserver config
# disable_functions = count

