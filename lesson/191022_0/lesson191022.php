<?php 

$file_read = "out.txt";

$file_write = "dir/out_2.txt";


file_put_contents($file_write, "script 1 wrote: 123\n");

$ar = range(5, 15);

foreach($ar as $key => $val)
{
    file_put_contents($file_write, "$key => $val\n", FILE_APPEND);
}

echo "work with file end" . "<br>";

echo nl2br( file_get_contents($file_read) );

?>