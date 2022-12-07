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
        'body' => 'o',
        'border' => '|',
        'free' => '-',
        'food' => '!',
    ];

    public $snake_length = 0;
    public $tick;

    public $cell = ['line_id' => 0, 'position', 'char']; # [x, y, (BLOCKED || FREE || FOOD) ]. Клетка поля
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
            } elseif ($char == $char_map['border']) {
                $cell['char'] = $char_map['border'];
            } elseif ($char == $char_map['free']) {
                $cell['char'] = $char_map['free'];
            } elseif ($char == "\r") {
                $cell['char'] = "\n";
            }
            
            $cell['line_id'] = $x;
            $cell['position'] = $y;
            $y++;
            $space[] = $cell;
        }
        $this->space = $space;
    }

    public function main(): void
    {
        // while ($this->can_move()) {
        //     $this->draw_table();
        //     usleep($this->tick);
        //     $this->move();
        // }

        // var_dump($this->space);
        echo nl2br($this->draw_table());
    }

    private function draw_table(): string
    {
        $res = '';

        foreach ($this->space as $cell) {
            $res .= $cell['char'];
        }

        return $res;
    }


    private function can_move(): bool
    {
        return false;
    }

    private function move(): void
    {
    }

    private function get_plain_space(): array 
    {
        $res = [];
        foreach($this->space as $cell) {
            if($cell['char'] == "\n") {
                continue;
            } else {
                $res[] = $cell;
            }
        }
        return $res;
    }

    private function get_direction(): array
    {
        return [];
    }

}