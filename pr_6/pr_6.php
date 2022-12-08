<pre>
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

    private $tick;
    private $snake_length = 0;
    private $food_cell;
    private $head_cell;
    private $space = []; # array of cells


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
        $this->space = $space;
    }

    public function main(): void
    {
        # Создание головы
        $this->space[1]->char = $this->char_map['head_right'];
        $this->head_cell = $this->space[1];

        $this->food_cell = $this->create_food();

        # Основной цикл
        while ($this->can_move()) {
            echo nl2br($this->draw_table($this->space));
            usleep($this->tick);
            $this->move_to($this->food_cell);

        }

        // echo nl2br($this->draw_table($this->space));

    }


    /**
     * Рисует игровое поле
     * @param array $space
     * @return string
     */
    private function draw_table(array $space): string
    {
        $res = '';

        ### DEBUG ###
        if (empty($space)) {
            $space = $this->space;
        }
        #############

        foreach ($space as $cell) {
            $res .= $cell->char;
        }

        return $res;
    }

    # 
    private function can_move(): bool
    {
        # Есть свободные клетки вокруг головы
        $res = false;
        return $res;
    }
    

    private function move_to(Cell $target): void 
    {
        $current_position = ['column' => $this->head_cell->column, 'position' => $this->head_cell->position];
        $target_position = ['column' => $target->column, 'position' => $target->position];
        $base_direction = $this->head_cell->char;
        $direction = DIRECTION::RIGHT;

        enum DIRECTION {
            case UP = $this->char_map['head_up'];
            case DOWN = $this->char_map['head_down'];
            case RIGHT = $this->char_map['head_right'];
            case LEFT = $this->char_map['head_left'];
        }

        if ($target_position['column'] > $current_position['column']) {
            $direction = DIRECTION::UP;
        } elseif ($target_position['column'] == $current_position['column']) {

            if ($target_position['position'] > $current_position['position']) {
                $direction = DIRECTION::RIGHT;
            } else {
                $direction = DIRECTION::LEFT;
            }

        } else {
            $direction = DIRECTION::DOWN;
        }

        # Двигаем, только если направление к цели совпадает с изначальным, иначе просто поворачиваем голову в нужное направление
        if ($base_direction == $direction) {

        } else {
            $this->head_cell->char = $direction; # Поворот башки
        }
    }

    /**
     * Получает игровое поле без скрытых клеток.
     * @return array
     */
    private function get_plain_space(): array
    {
        $res = [];
        foreach ($this->space as $cell) {
            if ($cell->char == "\n") {
                continue;
            } else {
                $res[] = $cell;
            }
        }
        return $res;
    }
    
    /**
     * Создает еду в случайной клетке поля
     * @return Cell
     */
    private function create_food(): Cell 
    {
        $space = $this->get_plain_space();
        $res = $space[array_rand($space)];
        
        # Клетка должна быть доступна
        while($res->char != $this->char_map['free']) {
            $res = $space[array_rand($space)];
        }
        $res->char = $this->char_map['food'];

        return $res;
    }

    private function eat(): void 
    {
        // 
    }

    /**
     * Найти клетку по позиции
     * @param array $needle [column, position]
     * @param array $haystack
     * @return Cell
     */
    private function find_cell(array $needle, array $haystack): Cell 
    {
        $res = new Cell();
        foreach ($haystack as $cell) {
            if ($cell->column == $needle[0] and $cell->position == $needle[1]) {
                $res = $cell;
                break;
            }
        }

        return $res;
    }
}


class Cell  
{
    public $column;
    public $position;
    public $char;

    function __construct(int $column = 0, int $position = 0, string $char = '') {
        $this->column = $column;
        $this->position = $position;
        $this->char = $char;
    }

}