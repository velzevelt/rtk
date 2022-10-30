<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица Пифагора</title>

    <style>
        table, td
        {
            border-collapse: collapse;
        }
        table, caption
        {
            font-size: 2ex;
            padding: 8px;
        }
        td
        {
            border: 2px solid black;
            padding: 10px;
            width: 30px;
            height: 30px;
        }
        td.outer
        {
            background: #8BBCCC;
        }

        .main
        {
            font-family: Arial;
            font-size: 3.5ex;
            text-align: center;
            display: flex;
            justify-content: center;            
        }

    </style>
</head>
<body>
    <div class = "main">
<?php 

$x = 0;
$y = 0;

$start = "<table>
    <caption>Таблица Пифагора</caption>";


$out = $start;

while( $y < 10 )
{
    $out .= "<tr>";

    while( $x < 10 )
    {
        $res = $x * $y;
        $temp = "";
        $outer = false;

        if ($res == 0)
        {
            $temp = ($x > 0) ? $x : ($y > 0 ? $y : "");
            $outer = true;
        }
        else
        {
            $temp = $res;
        }

        $out .= $outer ? "<td class='outer'>" . $temp : "<td>" . $temp;
        $out .= "</td>";

        $x++;
    }

    $out .= "</tr>";
    
    $y++;
    $x = 0;
}


$out .= "</table>";

echo $out;




?>
</div>

</body>
</html>