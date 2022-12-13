<pre>
<?php
const ROUNDS = 3;

const MAX_UNITS_IN_ARMY = 5;
const MAX_UNIT_HEALTH = 100;
const MIN_UNIT_HEALTH = 1;
const MAX_UNIT_DAMAGE = 45;
const MIN_UNIT_DAMAGE = 5;

const LOG_FILE = 'log.txt';

file_put_contents(LOG_FILE, "");

for ($i = 1; $i <= ROUNDS; $i++) {
    file_put_contents(LOG_FILE, "Раунд $i\n", FILE_APPEND);
    $game = new Game( [new Army('white'), new Army('black')] );
    $game->main();
}

echo nl2br(file_get_contents(LOG_FILE));

//TODO
/**
 * Game принимает любое количество армий
 * враг выбирается случайно
 * армия ходит случайно
 * атакует один случайный юнит по случайной армии, после атаки очередь хода передаётся
 */

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
        $current_enemy = $this->get_rand_army($current_player); # pick random army exclude current_player 
        $move_id = 1;

        # Игра продолжается, пока есть хотя бы две живые армии
        while ($this->has_two_alive()) {
            $current_player->make_move($current_enemy);

            if ($current_player->is_winner($current_enemy)) {
                # Стереть побежденную армию remove(current enemy) from armies[]
                $key = array_search($current_enemy, $armies);
                array_
            }

            $current_player = $this->get_rand_army();
            $current_enemy = $this->get_rand_army($current_player);
            $move_id++;

        }

       
    }

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

    private function has_two_players(): bool {}
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


    function make_move($enemy_army)
    {   
        $unit_id = array_rand($this->units);
        $unit = $this->units[$unit_id];
        

    }
    function can_move($enemy_army): bool # Игрок может ходить, если у нас и у врага есть живые юниты
    {
        $res = $this->kills != MAX_UNITS_IN_ARMY;
        return $res;
    }

    function is_winner($enemy_army): bool
    {
        return !($this->can_move($enemy_army));
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

    function take_damage($damage)
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