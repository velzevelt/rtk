<?php 

// 1

function solve_equation(int $a = 1, int $b = 1, int $c = 1): array
{
    $d = $b ** 2 - 4 * $a * $c;
    if ($d <= 0)
    {
        return ($d == 0 and $a != 0) ? [ -$b / 2 * $a ] : [];
    }
    else
    {
        $d_root = sqrt($d);
        $t = 2 * $a;
        return [ (-$b + $d_root) / $t, (-$b - $d_root) / $t ];
    }
}

var_dump( solve_equation(4, -6, 0) );



// 2

// $x = function($a = 1, $b = 1, $c = 1) {

//     $d = $b ** 2 - 4 * $a * $c;
//     if ($d <= 0)
//     {
//         return ($d == 0 and $a != 0) ? [ -$b / 2 * $a ] : [];
//     }
//     else
//     {
//         $d_root = sqrt($d);
//         $t = 2 * $a;
//         return [ (-$b + $d_root) / $t, (-$b - $d_root) / $t ];
//     }

// };

// var_dump( $x(4, -6, 0) );

?>
