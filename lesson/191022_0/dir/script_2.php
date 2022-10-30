<?php 

$file_read = "out_23.txt";

$file_write = "../out.txt";


file_put_contents($file_write, "script 2 wrote: 123\n");

$ar = range(2, 15);

foreach($ar as $key => $val)
{
    file_put_contents($file_write, "$key => $val\n", FILE_APPEND);
}

echo "work with file end" . "<br>";

if( file_exists($file_read) )
{
    echo nl2br( file_get_contents($file_read) );
}
else
{
    echo "$file_read file doesn't exist";
}

?>