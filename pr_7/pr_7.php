<pre>
<?php
const ROUNDS = 3;


const MAX_UNITS_IN_ARMY = 5;

const MAX_UNIT_HEALTH = 100;
const MIN_UNIT_HEALTH = 1;

const MAX_UNIT_DAMAGE = 45;
const MIN_UNIT_DAMAGE = 5;


const LOG_FILE = 'log.txt';

# Очистка/Создание Лога
file_put_contents(LOG_FILE, "");



for ($i = 1; $i <= ROUNDS; $i++) {
    file_put_contents(LOG_FILE, "Раунд $i\n", FILE_APPEND);
    $game = new Game( [new Army('white'), new Army('black')] );
    $game->main();
}

echo nl2br(file_get_contents(LOG_FILE));


class Game
{
    private $armies = [];

    public function __construct(array $armies)
    {
        $this->armies = $armies;
    }

    public function main(): void
    {   
        $current_player = $this->get_rand_army(); # pick random army
        $current_enemy = $this->get_rand_army([$current_player]); # pick random army exclude current_player 
        $move_id = 1;

        # Игра продолжается, пока есть хотя бы две живые армии
        while ($this->has_two_players()) {
            
            if($current_player->can_move() and $current_enemy->can_move()) {
                $current_player->make_move($current_enemy);
                
            } else {
                # Какая-то из армий выбыла, удаляем её
                # Определяем проигравшего
                $loser = $current_player->can_move() ? $current_enemy : $current_player;
                
                $key = array_search($loser, $this->armies);
                unset($this->armies[$key]);
                $this->armies = array_values($this->armies);
            }
            
            //* Доп проверка нужна, так как на предыдущем шаге произошло удаление и теперь живых игроков может не хватать
            if ($this->has_two_players()) {
                $current_player = $this->get_rand_army();
                $current_enemy = $this->get_rand_army([$current_player]);
            }

            $move_id++;

        }

       
    }

    /**
     * Получить случайную армию из $this->armies
     * @param array $exclude Исключить армии из выборки
     * @return mixed
     */
    private function get_rand_army(array $exclude = []) 
    {
        $armies = $this->armies;
        $r = false;

        if (!empty($exclude)) {
            $armies = array_diff($exclude, $armies);
        }

        $rand_id = array_rand($armies);
        $r = $armies[$rand_id];

        return $r;
    }

    private function has_two_players(): bool 
    {
        return (count($this->armies) >= 2);
    }
}

//TODO Часть логирования сюда
class Army
{
    public $name = "";
    public $units = [];

    function __construct($name = '')
    {
        for ($i = 0; $i < MAX_UNITS_IN_ARMY; $i++) {
            array_push($this->units, new Unit());
        }
        if (!(isset($name))) {
            $name = random_int(0, 1500); 
        }

        $this->name = $name;
    }


    function make_move(Army $enemy_army)
    {
        $attacker = $this->get_active_unit();
        $target = $enemy_army->get_active_unit();
        $attacker->attack($target);
    }

    /**
     * Игрок может ходить, если есть хотя бы 1 живчик
     * @param mixed $enemy_army
     * @return bool
     */
    function can_move(): bool
    {
        $res = false;

        foreach($this->units as $unit) {
            if ($unit->active) {
                $res = true;
                break;
            }
        }

        return $res;
    }
    /**
     * Получить случайного живого юнита
     * @return Unit
     */
    function get_active_unit(): Unit
    {
        $rand_id = array_rand($this->units);
        $rand_unit = $this->units[$rand_id];

        while($rand_unit->destroyed) {
            $rand_id = array_rand($this->units);
            $rand_unit = $this->units[$rand_id];
        }

        return $rand_unit;
    }

    function get_units_health(): int
    {
        $res = 0;
        foreach ($this->units as $unit) {
            if ($unit->destroyed) # Считаем здоровье только живчиков
            {
                continue;
            }
            $res += $unit->health;
        }
        return $res;
    }

    function get_dead(): string
    {
        $res = "";

        foreach ($this->units as $key => $unit) {
            if ($unit->destroyed) {
                $res .= $key;
                $res .= " ";
            }
        }

        return $res;
    }

    function count_alive(): int
    {
        $res = 0;
        foreach ($this->units as $unit) {
            if ($unit->active) {
                $res++;
            }
        }
        return $res;
    }
}


//TODO Перенести логирование сюда
class Unit
{
    public $health;
    public $damage;
    public $active = true;
    public $destroyed = false;

    function __construct()
    {
        $this->health = MAX_UNIT_HEALTH;
        $this->damage = random_int(MIN_UNIT_DAMAGE, MAX_UNIT_DAMAGE);
    }

    private function take_damage($damage)
    {
        $this->health -= $damage;

        if ($this->health < MIN_UNIT_HEALTH) {
            $this->active = false;
            $this->destroyed = true;
        }
    }

    function attack(Unit $target)
    {
        $target->take_damage($this->damage);
    }

    function is_alive(): bool
    {
        return ($this->active and !($this->destroyed));
    }
}

?>