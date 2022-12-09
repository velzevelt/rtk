<?php
function format_problem(string $problem_id)
{
    $message = "<h4 style = 'color: #ACD1AF'> Задание <empty style = 'color: #EEEE9B;'>$problem_id</empty> </h4>";
    echo $message;
}

function console_log($data){
    if(is_array($data) || is_object($data)){
        echo("<script>console.log('php_array: ".json_encode($data)."');</script>");
    } else {
        echo("<script>console.log('php_string: ".$data."');</script>");
    }
}

// /** разбирает число на цифры в обратном порядке
//  *  пример: 123.456 -> [ 6, 5, 4, 3, 2, 1 ]
//  */
// for ($i = 0, $k = $num; $i < 6; $i++, $k /= 10) {
//     $ticket[$i] = $k % 10;
// }



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



