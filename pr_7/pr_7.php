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
    function __construct(array $armies)
    {
        foreach($armies as $key => $_val) {
            $armies[$key]->armi
        }
        
        
        $this->armies = $armies;
    }

    function main(): void
    {
        $fate = mt_rand(0, 1);
        $first_player = $fate == 1 ? $this->white_army : $this->black_army;
        $second_player = $fate == 1 ? $this->black_army : $this->white_army;

        $current_player = $first_player;

        $move_id = 1;

        while ($current_player->can_move()) {
            file_put_contents(LOG_FILE, "Ход $move_id: $current_player->name атакует\n", FILE_APPEND);
            $current_player->make_move();

            if ($current_player->is_winner()) {
                break;
            }

            $current_player = $current_player == $first_player ? $second_player : $first_player;
            $move_id++;

            file_put_contents(LOG_FILE, "\n", FILE_APPEND);
        }

        $winner = $first_player->is_winner() ? $first_player : $second_player;

        $game_result = "Победитель: $winner->name, осталось юнитов " . $winner->count_alive();
        $game_result .= " их общее здоровье составляет " . $winner->get_units_health();

        if ($winner->count_alive() != MAX_UNITS_IN_ARMY) # Если кто-то погиб, сообщаем об этом
        {
            $game_result .= " убиты юниты с ключами " . $winner->get_dead();
        }

        $game_result .= "\n\n";

        file_put_contents(LOG_FILE, $game_result, FILE_APPEND);
    }
}

class Army
{
    public $name = "";
    public $units = [];
    public $enemy_armies;
    public $enemy_units; # получать из случайной вражеской армии
    // public $kills = 0;

    function __construct($name = '')
    {
        for ($i = 0; $i < MAX_UNITS_IN_ARMY; $i++) {
            array_push($this->units, new Unit());
        }
        if (!(isset($name))) { 
            $name = random_int(); 
        }

        $this->name = $name;
    }


    function make_move()
    {   
        $unit_id = array_rand($this->units);
        $unit = $this->units[$unit_id];
        // if (!($unit->is_alive())) # Мертвецы не могут атаковать
        //     {
        //         continue;
        //     }

        //     $target_id = array_rand($this->enemy_units);
        //     $target = $this->enemy_units[$target_id];

        //     while (!($target->is_alive())) # Нельзя атаковать мертвых, ищем живую цель
        //     {
        //         if ($this->is_winner()) # Игрок победил, у противника не осталось юнитов
        //         {
        //             break 2;
        //         }
        //         $target_id = array_rand($this->enemy_units);
        //         $target = $this->enemy_units[$target_id];
        //     }

        //     $unit->attack($target);
        //     file_put_contents(LOG_FILE, "юнит $unit_id нанес урон $unit->damage вражескому юниту $target_id, у врага осталось $target->health здоровья\n", FILE_APPEND);

        //     if (!($target->is_alive())) # Регистрация убитого противника
        //     {
        //         file_put_contents(LOG_FILE, "юнит $unit_id убил вражеского юнита $target_id\n", FILE_APPEND);
        //         $this->kills++;
        //     }


            # Атака для каждого
        // foreach ($this->units as $unit_id => $unit) {
        //     if (!($unit->is_alive())) # Мертвецы не могут атаковать
        //     {
        //         continue;
        //     }

        //     $target_id = array_rand($this->enemy_units);
        //     $target = $this->enemy_units[$target_id];

        //     while (!($target->is_alive())) # Нельзя атаковать мертвых, ищем живую цель
        //     {
        //         if ($this->is_winner()) # Игрок победил, у противника не осталось юнитов
        //         {
        //             break 2;
        //         }
        //         $target_id = array_rand($this->enemy_units);
        //         $target = $this->enemy_units[$target_id];
        //     }

        //     $unit->attack($target);
        //     file_put_contents(LOG_FILE, "юнит $unit_id нанес урон $unit->damage вражескому юниту $target_id, у врага осталось $target->health здоровья\n", FILE_APPEND);

        //     if (!($target->is_alive())) # Регистрация убитого противника
        //     {
        //         file_put_contents(LOG_FILE, "юнит $unit_id убил вражеского юнита $target_id\n", FILE_APPEND);
        //         $this->kills++;
        //     }
        // }
    }
    function can_move(): bool # Игрок может ходить, если у противника есть хотя бы один живой юнит
    {
        $res = $this->kills != MAX_UNITS_IN_ARMY;
        return $res;
    }

    function is_winner(): bool
    {
        return !($this->can_move());
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