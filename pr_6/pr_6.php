<pre>
<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


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

set_time_limit(60*3);
$snake2D = new Snake2D('snake2D.txt');
$snake2D->main();


//TODO Потестить змею на начальной колонке

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
        'food' => "<empty style='color: #FF0000'>!</empty>",
        /////////////
    ];


    private $active = true;
    private $food_cell;
    private $head_cell;
    private $space = []; # array of cells


    /**
     * Змеюка
     * @param string $filename Имя файла с исходным игровым полем
     * @param int $tick Время одного хода (в микросекундах)
     */
    function __construct(string $filename)
    {

        $content = str_split(trim(file_get_contents($filename)));


        $char_map = $this->char_map;
        $space = $this->space;

        $x = 0;
        $y = 0;
        # Формируем игровое поле
        foreach ($content as $char) {
            $cell = new Cell();
            if ($char == "\n") {
                $x++;
                $y = 0;

                $cell->char = $char;
            } elseif ($t = array_search($char, $char_map)) {
                $cell->char = $char_map[$t];
            }

            $cell->column = $x;
            $cell->position = $y;
            $space[] = $cell;
            
            $y++;
        }
        $this->space = $space;
    }

    public function main(): void
    {
        # Создание головы
        $head_id = array_rand($this->space);

        while( !($this->is_valid($this->space[$head_id], [ $this->char_map['free'] ])) ) {
            $head_id = array_rand($this->space);
        }

        $this->space[$head_id]->char = $this->char_map['head_right'];
        $this->head_cell = &$this->space[$head_id];

        $this->food_cell = $this->create_food();

        # Основной цикл
        while ($this->active) {
            // ob_start();
            echo nl2br($this->draw_table($this->space));

            echo "<br>";
            echo "<br>";
            echo "<br>";
            
            ob_flush();
            flush();
            sleep(1);

            // ob_end_clean();
            

            $this->move_to($this->food_cell);

        }
        echo "<br>";
        echo "Мы погибли, какое горе!";


        // for($i = 0; $i < 200; $i++) {
        //     if($this->active) {
        //         echo nl2br($this->draw_table($this->space));

        //         echo "<br>";
        //         echo "<br>";
        //         echo "<br>";
    
        //         $this->move_to($this->food_cell);
        //     } else {
        //         echo "<br>";
        //         echo "Мы погибли, какое горе!";
        //         break;
        //     }
            
        // }
    }


    /**
     * Рисует игровое поле
     * @param array $space
     * @return string
     */
    private function draw_table(array $space): string
    {
        $res = '';

        foreach ($space as $cell) {
            $res .= $cell->char;
        }

        return $res;
    }


    private function move_to(Cell $target): void 
    {
        $current_position = ['column' => $this->head_cell->column, 'position' => $this->head_cell->position];
        $target_position = ['column' => $target->column, 'position' => $target->position];
        $current_direction = $this->head_cell->char;
        $target_direction = null;
        $new_position = ['column' => $current_position['column'], 'position' => $current_position['position']];



        # Базовое определение направления
        if ($target_position['column'] > $current_position['column']) {
            $target_direction = $this->char_map['head_down'];
            $new_position['column'] = $current_position['column'] + 1;

        } elseif ($target_position['column'] == $current_position['column']) {

            if ($target_position['position'] > $current_position['position']) {
                $target_direction = $this->char_map['head_right'];
                $new_position['position'] = $current_position['position'] + 1;
            } else {
                $target_direction = $this->char_map['head_left'];
                $new_position['position'] = $current_position['position'] - 1;
            }

        } else {
            $target_direction = $this->char_map['head_up'];
            $new_position['column'] = $current_position['column'] - 1;
        }



        # Двигаем, только если направление к цели совпадает с изначальным, иначе просто поворачиваем голову в нужное направление
        if ($current_direction == $target_direction) {
            $t = new Cell($new_position['column'], $new_position['position']);

            // var_dump($current_position);
            // var_dump($new_position);

            
            if ($key = $this->find_cell($t, $this->space)) {
                $this->head_cell->char = $this->char_map['body']; # reset prev

                
                # Эта язва исправляет смещение, вызванное скрытыми символами
                if ( $t->column == 0 or $this->head_cell->column == 0 ) {

                    if($current_direction == $this->char_map['head_down']) {
                        $t->position++;
                    } elseif($current_direction == $this->char_map['head_up']) {
                        $t->position--;
                    }

                    $key = $this->find_cell($t, $this->space);
                }

                if ($this->space[$key]->char == $this->char_map['food']) {
                    $this->eat();
                } elseif ($this->space[$key]->char == $this->char_map['body']) {
                    # СМЕРТЬ
                    $this->active = false;
                }
                $this->head_cell = &$this->space[$key];
                $this->head_cell->char = $target_direction;
            }

        } else {
            # Поворот башки
            $this->head_cell->char = $target_direction;
        }
    }

    private function is_valid(Cell $cell, array $white_list): bool 
    {
        // $white_list = [$this->char_map['free'], $this->char_map['food'], $this->char_map['body']];
        return in_array($cell->char, $white_list);
    }
    
    /**
     * Найти клетку по её позиции
     * @param Cell $needle
     * @param array $haystack
     * @return mixed
     */
    private function find_cell(Cell $needle, array $haystack)
    {
        $r = false;

        foreach($haystack as $key => $cell) {
            if($cell->column == $needle->column and $cell->position == $needle->position) {
                $r = $key;
                break;
            }
        }

        return $r;
    }

    /**
     * Создает еду в случайной клетке поля
     * @return Cell
     */
    private function create_food(): Cell 
    {
        $space = $this->space;
        $res = $space[array_rand($space)];
        
        # Клетка должна быть доступна
        while( !($this->is_valid($res, [$this->char_map['free']])) ) {
            $res = $space[array_rand($space)];
        }
        $res->char = $this->char_map['food'];

        return $res;
    }

    private function eat(): void 
    {
        $this->food_cell = $this->create_food();
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

