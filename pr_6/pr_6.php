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
    const DEFAULT_CELL = ['column' => 0, 'position' => 0, 'char' => '→'];
    public $char_map = [
        'head_right' => '→',
        'head_left' => '←',
        'head_up' => '↑',
        'head_down' => '↓',

        'body' => '*',
        

        'border' => '|',
        'free' => '-',
        'food' => '!',
    ];

    public $tick;
    public $cell = ['column' => 0, 'position' => 0, 'char']; # [x, y, from char_map[any] ]. Клетка поля
    public $food_cell = [];
    public $head_cell = [];
    public $space = []; # array of cells


    /**
     * Змеюка
     * @param mixed $_filename Имя файла с исходным игровым полем
     * @param mixed $_tick Время одного хода (в микросекундах)
     */
    function __construct($_filename, $_tick = 250000)
    {

        $content = str_split(file_get_contents($_filename));

        # (optional) [Set char map]

        $this->tick = $_tick;
        $this->head_cell = Snake2D::DEFAULT_CELL;

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
                continue;
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
        while ($this->can_move()) {
            $this->draw_table();
            usleep($this->tick);
            $this->move();

        }

        // var_dump($this->space);
        // echo nl2br($this->draw_table($this->get_plain_space()));
    }
    /**
     * Рисует игровое поле
     * @param array $space
     * @return string
     */
    private function draw_table(array $space = []): void
    {
        $res = '';
        if (empty($space)) {
            $space = $this->space;
        }

        foreach ($space as $cell) {
            $res .= $cell['char'];
        }

        echo $res;
    }

    # 
    private function can_move(): bool
    {
        return false;
    }
    
    # Растет каждый ход. Оставляет след на пред поз головы
    private function move(): void {}

    /**
     * Получает игровое поле без скрытых ячеек.
     * @return array
     */
    private function get_plain_space(): array
    {
        $res = [];
        foreach ($this->space as $cell) {
            if ($cell['char'] == "\n") {
                continue;
            } else {
                $res[] = $cell;
            }
        }
        return $res;
    }
    
    /**
     * Получает направление от головы до клетки
     * @param array $cell
     * @return array $cell
     */
    private function get_direction_to(array $cell): array
    {
        $from = $this->head_cell;
        return [];
    }

    # Появляется в случайной точки таблицы
    private function create_food(): void {}
}