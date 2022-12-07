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
    public $base_line = "";
    public $filename = "";

    function __construct($_filename, $_out_path = ".o")
    {
        $this->base_line = file_get_contents($_filename);
        $this->filename = $_filename . $_out_path;
    }

    function main(): void
    {
        if ($file = fopen($this->filename, "w+")) {
            $line = $this->base_line;

            for ($head_pos = 0, $j = strlen($line); $head_pos < $j; $head_pos++) {
                $line[$head_pos] = '>';
                $line = substr_replace($line, str_repeat('*', $head_pos), 0, $head_pos);
                fwrite($file, $line . "\n");
            }

            fclose($file);
        }
    }
}


// $snake = new Snake("snake.txt");
// $snake->main();

$snake2D = new Snake2D('snake2D.txt');
$snake2D->main();

class Snake2D
{
    public $border_char;
    public $tick;

    const BLOCKED = 0; # Нельзя ходить, клетка занята (граница или змея)
    const FREE = 1; # 1 Поле свободно, змея может здесь быть
    public $cell = ['line_id' => 0, 'position', 'state']; # [x, y, (BLOCKED || FREE) ]. Клетка поля
    public $space = []; # array of cells

    /**
     * Summary of __construct
     * @param mixed $_filename
     * @param mixed $_border_char Символ конца игрового поля
     * @param mixed $_tick Время одного хода (в микросекундах)
     */
    function __construct($_filename, $_border_char = '|', $_tick = 250000)
    {

        $content = str_split(file_get_contents($_filename));

        $this->border_char = $_border_char;
        $this->tick = $_tick;

        $space = $this->space;
        $cell = $this->cell;
        $x = 0;
        # Формируем игровое поле
        foreach ($content as $key => $char) {
            if ($char == "\n") { # Начало новой строки
                $x++;
                $cell['line_id'] = $x;
            }
            
            $cell['position'] = $key;

            if ($char == $_border_char) {
                $cell['state'] = Snake2D::BLOCKED;
            } else {
                $cell['state'] = Snake2D::FREE;
            }

            $space[$key] = $cell;
        }
        $this->space = $space;
    }

    public function main(): void
    {
        var_dump($this->space);
    }
}