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
    private $char_map = [
        // [HEAD] //
        'head_right' => '→',
        'head_left' => '←',
        'head_up' => '↑',
        'head_down' => '↓',
        ////////////

        'body' => '*',
        
        // [CELLS] //
        'border' => '|',
        'free' => '-',
        'food' => '!',
        /////////////
    ];

    private int $tick;
    private int $snake_length = 0;
    private Cell $food_cell = new Cell();
    private Cell $head_cell = new Cell();
    private array $space = []; # array of cells
    private int $column_max = 0;
    private int $position_max = 0;


    /**
     * Змеюка
     * @param string $filename Имя файла с исходным игровым полем
     * @param int $tick Время одного хода (в микросекундах)
     */
    function __construct(string $filename, int $tick = 250000)
    {

        $content = str_split(file_get_contents($filename));

        $this->tick = $tick;

        $char_map = $this->char_map;
        $space = $this->space;

        $x = 0;
        $y = 0;
        # Формируем игровое поле
        foreach ($content as $key => $char) {
            $cell = new Cell();
            if ($char == "\n") {
                $x++;
                $y = 0;
                continue;
            } elseif ($char == $char_map['border']) {
                $cell->char = $char_map['border'];
            } elseif ($char == $char_map['free']) {
                $cell->char = $char_map['free'];
            } elseif ($char == "\r") {
                $cell->char = "\n";
            }

            $cell->column = $x;
            $cell->position = $y;
            $y++;
            $space[] = $cell;
        }

        $last = $space[array_key_last($space)];
        $this->column_max = $last->column;
        $this->position_max = $last->position;

        $this->space = $space;
    }

    public function main(): void
    {
        while ($this->can_move()) {
            $this->draw_table();
            usleep($this->tick);
            $this->move_to($this->food_cell);

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

        ### DEBUG ###
        if (empty($space)) {
            $space = $this->space;
        }
        #############

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
    
    # 
    private function move_to(Cell $target): void 
    {
    }

    /**
     * Получает игровое поле без скрытых клеток.
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
    
    # Создает еду в случайной клетке таблицы. Клетка должна быть доступна
    private function create_food(): Cell 
    {
        $res = new Cell();

        return $res;
    }
    private function eat(): void {}
}


class Cell  
{
    public int $column = 0;
    public int $position = 0;
    public string $char = '';
}