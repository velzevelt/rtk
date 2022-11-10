<?php 

# Задача 1. Написать программу, змейку, которая съедает линию
# Результат работы класса – файл в котором на первой строчке исходная линия, а 
# далее в каждой строке пошаговое «съедание» линии змейкой
# Пример реализации
# 1)>-------------------
# 2)*>------------------
# 3)**********>---------
# 4)****************>---

class Snake
{
    private $_base_line = "";
    private $_filename = "";

    function __construct($filename, $out_path = ".o")
    {
        $this->_base_line = file_get_contents($filename);
        $this->_filename = $filename . $out_path;
    }
    
    function main(): void
    {   
        if( $file = fopen( $this->_filename, "w+") )
        {
            $line = $this->_base_line;

            for($head_pos = 0, $j = strlen( $line ); $head_pos < $j; $head_pos++)
            {
               $line[$head_pos] = '>';
               $line = substr_replace($line, str_repeat('*', $head_pos), 0, $head_pos);
               fwrite($file, $line . "\n"); 
            }

            fclose($file);
        }
    }
}


$snake = new Snake("snake.txt");
$snake->main();

class Snake2D
{
    private $_space = [ [] ]; // x y
    private $_filename = '';
}

?>