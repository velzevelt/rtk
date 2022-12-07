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

class Snake2D # Растет каждый ход. Направление случайная точка из макс горизонт вертикаль
{
    public $char_map = [
        'head' => '*',
        'border' => '|',
        'free' => '-',
        'food' => '!',
        'br' => "<br>",
    ];

    public $snake_length = 0;
    public $tick;

    const BLOCKED = 0; # Нельзя ходить, клетка занята (граница или змея)
    const FREE = 1; # Поле свободно, змея может здесь быть
    // const FOOD = 2; # В поле есть еда
    public $cell = ['line_id' => 0, 'position', 'state', 'char']; # [x, y, (BLOCKED || FREE || FOOD) ]. Клетка поля
    public $space = []; # array of cells

    /**
     * Summary of __construct
     * @param mixed $_filename
     * @param mixed $_tick Время одного хода (в микросекундах)
     */
    function __construct($_filename, $_tick = 250000)
    {
        
        $content = str_split(file_get_contents($_filename));
        
        #!!! [Set char map]
        
        $this->tick = $_tick;

        $char_map = $this->char_map;
        $space = $this->space;
        $cell = $this->cell;

        $x = 0;
        $y = 0;
        # Формируем игровое поле
        foreach ($content as $key => $char) {
            if ($char == "\n") {
                $x++;
                $y = 0;
                $cell['line_id'] = $x;

            } elseif ($char == "\r") {
                continue;
            }

            $cell['position'] = $y;


            if ($char == $char_map['border']) {
                $cell['state'] = Snake2D::BLOCKED;
                $cell['char'] = $char_map['border']
            } else {
                $cell['state'] = Snake2D::FREE;
                $cell['char'] = $char_map['free']
            }
            
            $y++;
            $space[] = $cell;
        }
        $this->space = $space;
    }

    public function main(): void
    {
        foreach($this->space as $field) {
            $state = $field['state'];
            
            

        }
        var_dump($this->space);

    }
}