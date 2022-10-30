<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style="text-align:center">
<?php 


for($x = 1; $x < 26; $x++)
{
    $char = "*";
    $char = str_repeat($char, $x);
    echo $char . "<br>";
}

// for($x = 1, $max = 26; $x < $max; $x++)
// {
//     $char = "*";
//     $char = str_repeat($char, $x);
//     $space = str_repeat("&nbsp ", $max - $x);
//     echo $space . $char . "<br>";
// }


?>
    </div>
</body>
</html>
