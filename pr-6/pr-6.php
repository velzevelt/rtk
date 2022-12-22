<empty style='font-family: monospace; font-size: 20px;'>
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
        public $baseLine = "";
        public $whiteList = [
            '-'
        ];
        public $flag = false;

        public function __construct($_filename)
        {
            $this->baseLine = file_get_contents($_filename);
        }

        public function main($output): void
        {
            if ($file = fopen($output, "w+")) {
                $line = $this->baseLine;
                $line = str_split($line);
                // $temp;
                // $tempKey;
                foreach ($line as $key => $char) {
                    if (!($this->canMove($char)) and $this->flag == false) {
                        continue;
                    } else {
                        $this->flag = true;
                    }

                    if ($this->flag) {
                        if ($this->canMove($char)) {

                            if (isset($tempKey)) {
                                $line[$tempKey] = '*'; # change back
                            }

                            $temp = $char; # save
                            $tempKey = $key;

                            $char = '>'; # change
                            $line[$key] = $char;

                            fwrite($file, join($line) . "\n");
                        } else {
                            // echo 1; 
                            break;
                        }
                    }
                }

                // $line = join($line);
                // fwrite($file, $line . "\n");
                fclose($file);
            }
        }

        private function canMove($char): bool
        {
            return in_array($char, $this->whiteList);
        }
    }


    // $snake = new Snake("snake.txt");
    // $snake->main('snake.txt.o');
    



    set_time_limit(60 * 3);
    $snake2D = new Snake2D('snake2D.txt');
    $snake2D->main();



    class Snake2D
    {
        private $charMap = [
            // [HEAD] //
            'head_right' => "<empty style='color: #00D678'>→</empty>",
            'head_left' => "<empty style='color: #00D678'>←</empty>",
            'head_up' => "<empty style='color: #00D678'>↑</empty>",
            'head_down' => "<empty style='color: #00D678'>↓</empty>",
            ////////////
    
            'body' => "<empty style='color: #FF8000'>*</empty>",

            // [CELLS] //
            'border' => '|',
            'free' => '-',
            'food' => "<empty style='color: #FF0000'>!</empty>",
            /////////////
        ];


        private $active = true;
        private $foodCell;
        private $headCell;
        private $space = []; # array of cells
    
        /**
         * Змеюка
         * @param string $filename Имя файла с исходным игровым полем
         */
        function __construct(string $filename)
        {

            $content = str_split(trim(file_get_contents($filename)));


            $charMap = $this->charMap;
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
                } elseif ($t = array_search($char, $charMap)) {
                    $cell->char = $charMap[$t];
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

            while (!($this->isValid($this->space[$head_id], [$this->charMap['free']]))) {
                $head_id = array_rand($this->space);
            }

            $this->space[$head_id]->char = $this->charMap['head_right'];
            $this->headCell = & $this->space[$head_id];

            # Создание еды
            $this->foodCell = $this->createFood();


            # Основной цикл
            $output = '';
            while ($this->active) {
                echo nl2br($this->drawTable($this->space));
                $output .= $this->drawTable($this->space);

                echo "<p>";

                $output .= "\n";
                $output .= "\n";
                $output .= "\n";

                ob_flush();
                flush();
                sleep(1);



                $this->moveTo($this->foodCell);
            }
            echo "<br>";
            echo "Мы погибли, какое горе!";
            $output .= "\n";
            $output .= "Мы погибли, какое горе!";
            $output = strip_tags($output);

            file_put_contents('snake2D.txt.o', $output);
        }


        /**
         * Рисует игровое поле
         * @param array $space
         * @return string
         */
        private function drawTable(array $space): string
        {
            $res = '';

            foreach ($space as $cell) {
                $res .= $cell->char;
            }

            return $res;
        }


        private function moveTo(Cell $target): void
        {
            $currentPosition = ['column' => $this->headCell->column, 'position' => $this->headCell->position];
            $targetPosition = ['column' => $target->column, 'position' => $target->position];
            $currentDirection = $this->headCell->char;
            $targetDirection = null;
            $newPosition = ['column' => $currentPosition['column'], 'position' => $currentPosition['position']];



            # Базовое определение направления
            if ($targetPosition['column'] > $currentPosition['column']) {
                $targetDirection = $this->charMap['head_down'];
                $newPosition['column'] = $currentPosition['column'] + 1;
            } elseif ($targetPosition['column'] == $currentPosition['column']) {

                if ($targetPosition['position'] > $currentPosition['position']) {
                    $targetDirection = $this->charMap['head_right'];
                    $newPosition['position'] = $currentPosition['position'] + 1;
                } else {
                    $targetDirection = $this->charMap['head_left'];
                    $newPosition['position'] = $currentPosition['position'] - 1;
                }
            } else {
                $targetDirection = $this->charMap['head_up'];
                $newPosition['column'] = $currentPosition['column'] - 1;
            }



            # Двигаем, только если направление к цели совпадает с изначальным, иначе просто поворачиваем голову в нужное направление
            if ($currentDirection == $targetDirection) {
                $t = new Cell($newPosition['column'], $newPosition['position']);

                // var_dump($currentPosition);
                // var_dump($newPosition);
    

                if ($key = $this->findCell($t, $this->space)) {
                    $this->headCell->char = $this->charMap['body']; # reset prev
    

                    # Эта язва исправляет смещение, вызванное скрытым символом
                    if ($t->column == 0 or $this->headCell->column == 0) {

                        if ($currentDirection == $this->charMap['head_down']) {
                            $t->position++;
                        } elseif ($currentDirection == $this->charMap['head_up']) {
                            $t->position--;
                        }

                        $key = $this->findCell($t, $this->space);
                    }

                    if ($this->space[$key]->char == $this->charMap['food']) {
                        $this->eat();
                    } elseif ($this->space[$key]->char == $this->charMap['body']) {
                        # СМЕРТЬ
                        $this->active = false;
                    }
                    $this->headCell = & $this->space[$key];
                    $this->headCell->char = $targetDirection;
                }
            } else {
                # Поворот башки
                $this->headCell->char = $targetDirection;
            }
        }

        private function isValid(Cell $cell, array $whiteList): bool
        {
            // $whiteList = [$this->charMap['free'], $this->charMap['food'], $this->charMap['body']];
            return in_array($cell->char, $whiteList);
        }

        /**
         * Найти клетку по её позиции
         * @param Cell $needle
         * @param array $haystack
         * @return mixed
         */
        private function findCell(Cell $needle, array $haystack)
        {
            $r = false;

            foreach ($haystack as $key => $cell) {
                if ($cell->column == $needle->column and $cell->position == $needle->position) {
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
        private function createFood(): Cell
        {
            $space = $this->space;
            $res = $space[array_rand($space)];

            # Клетка должна быть доступна
            while (!($this->isValid($res, [$this->charMap['free']]))) {
                $res = $space[array_rand($space)];
            }
            $res->char = $this->charMap['food'];

            return $res;
        }

        private function eat(): void
        {
            $this->foodCell = $this->createFood();
        }
    }


    class Cell
    {
        public $column;
        public $position;
        public $char;

        function __construct(int $column = 0, int $position = 0, string $char = '')
        {
            $this->column = $column;
            $this->position = $position;
            $this->char = $char;
        }
    }