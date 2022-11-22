<?php
function format_problem(string $problem_id)
{
    $message = "<h4 style = 'color: #ACD1AF'> Задание <empty style = 'color: #EEEE9B;'>$problem_id</empty> </h4>";
    echo $message;
}


























































































































































































































// const COUNT_TRUE = 1;
// const COUNT_LAST = 0;

/**count redefine*/
// function count(array $array, int $mode = COUNT_TRUE ): int
// {
//     $res = 0;
//     foreach($array as $_v)
//     {
//         $res++;
//     }
//     if($mode != COUNT_TRUE)
//     {
//         $res--;
//     }
//     return $res;
// }

# change php.ini in openserver config
# disable_functions = count

