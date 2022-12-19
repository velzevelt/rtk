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


# Основной цикл
for ($i = 1; $i <= ROUNDS; $i++) {
    file_put_contents(LOG_FILE, "Раунд $i\n", FILE_APPEND);
    $game = new Game( [new Army('Мордор'), new Army('Валлирия'), new Army('Орда'), new Army('Дорн')] );
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
                file_put_contents(LOG_FILE, "Ход $move_id: ", FILE_APPEND);
                $current_player->make_move($current_enemy, $move_id);
                
            } else {
                # Какая-то из армий выбыла, находим и удаляем её
                $loser = $current_player->can_move() ? $current_enemy : $current_player;
                
                $key = array_search($loser, $this->armies);
                unset($this->armies[$key]);
                $this->armies = array_values($this->armies);
            }
            
            //* Доп проверка необходима, так как на предыдущем шаге произошло удаление и теперь живых игроков может не хватать для продолжения игры
            if ($this->has_two_players()) {
                $current_player = $this->get_rand_army();
                $current_enemy = $this->get_rand_army([$current_player]);
            }

            $move_id++;

        }
        # Мы всегда знаем, что "0" это победитель, так как на предыдущих шагах
        # все проигравшие армии были удалены из $this->armies и "0" - единственный виживший, т.е. победитель
        $winner = $this->armies[0];

        
        //* Логирование
        $game_result = "Победила армия '$winner->name'\n";

        $dead = $winner->get_dead();
        $dead_count = $winner->count_dead();
        $game_result .= "Выбыло: $dead_count ($dead)\n";

        $alive = $winner->get_alive();
        $alive_count = $winner->count_alive();
        $game_result .= "Остались: $alive_count ($alive)";
        $game_result .= "\n";

        file_put_contents(LOG_FILE, $game_result, FILE_APPEND);
       
    }

    /**
     * Получить случайную армию из $this->armies
     * @param array $exclude Исключить армии из выборки
     * @return Army
     */
    private function get_rand_army(array $exclude = []): Army
    {
        $armies = $this->armies;

        if (!empty($exclude)) {
            $t = [];
            foreach($this->armies as $army) {
                if (in_array($army, $exclude)) {
                    continue;
                }
                $t[] = $army;
            }
            $armies = $t;
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


class Army
{
    public $name = "";
    public $units = [];
    public $revenger;

    public function __construct($name = '')
    {
        for ($i = 0; $i < MAX_UNITS_IN_ARMY; $i++) {
            array_push($this->units, new Unit());
        }
        if (!(isset($name))) {
            $name = random_int(0, 1500); 
        }

        $this->name = $name;
    }


    public function make_move(Army $enemy_army)
    {
        $attacker = $this->get_active_unit();
        $target = $enemy_army->get_active_unit();
        $attacker->attack($target);

        //* Логирование
        $attacker_key = array_search($attacker, $this->units);
        $target_key = array_search($target, $enemy_army->units);
        $this->attack_log($attacker, $target, $attacker_key, $target_key, $enemy_army);

        # Месть. Смена ролей
        if ($target->active) {
            // file_put_contents(LOG_FILE, "Ход $move_id: ", FILE_APPEND);
            file_put_contents(LOG_FILE, "Ход $move_id: Ответная Атака! ", FILE_APPEND);
            $target->attack($attacker);

            $enemy_army->attack_log($target, $attacker, $target_key, $attacker_key, $this);
        }
        
    }

    private function attack_log(Unit $attacker, Unit $target, string $attacker_key, string $target_key, Army $enemy_army) 
    {
        // $attacker_key = array_search($attacker, $this->units);
        // $target_key = array_search($target, $enemy_army->units);
        $message = "Армия '$this->name': Юнит '$attacker_key' атакует(урон: $attacker->damage) юнита '$target_key' из Армии '$enemy_army->name'\n";
        $message .= "У вражеского юнита '$target_key' осталось $target->health здоровья\n";
        file_put_contents(LOG_FILE, $message, FILE_APPEND);
    }

    /**
     * Игрок может ходить, если есть хотя бы 1 живчик
     * @param mixed $enemy_army
     * @return bool
     */
    public function can_move(): bool
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
    public function get_active_unit(): Unit
    {
        $rand_id = array_rand($this->units);
        $rand_unit = $this->units[$rand_id];

        while($rand_unit->destroyed) {
            $rand_id = array_rand($this->units);
            $rand_unit = $this->units[$rand_id];
        }

        return $rand_unit;
    }

    public function get_units_health(): int
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

    public function get_dead(): string
    {
        $res = "";

        foreach ($this->units as $key => $unit) {
            if ($unit->destroyed) {
                $res .= $key;
                $res .= " ";
            }
        }
        $res = trim($res);
        
        return $res;
    }

    public function get_alive(): string
    {
        $res = "";

        foreach ($this->units as $key => $unit) {
            if ($unit->active) {
                $res .= $key;
                $res .= " ";
            }
        }
        $res = trim($res);

        return $res;
    }
    
    public function count_dead(): int {
        $res = 0;
        foreach ($this->units as $key => $unit) {
            if ($unit->destroyed) {
                $res++;
            }
        }
        return $res;
    }

    public function count_alive(): int {
        $res = 0;
        foreach ($this->units as $key => $unit) {
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

    public function __construct()
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

    public function attack(Unit $target)
    {
        $target->take_damage($this->damage);
    }

}

?>