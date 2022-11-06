<pre>
<?php 
const ROUNDS = 3;

const MAX_UNITS_IN_ARMY = 25;
const MAX_UNIT_HEALTH = 100;
const MAX_UNIT_DAMAGE = 45;
const MIN_UNIT_DAMAGE = 5;

class Game
{
    public $white_army;
    public $black_army;
    function __construct($white_army, $black_army)
    {
        $this->white_army = $white_army;
        $this->black_army = $black_army;

        $this->white_army->enemy_units = $this->black_army->units;
        $this->black_army->enemy_units = $this->white_army->units;
    }

    function main(): void
    {
        $fate = mt_rand(0, 1);
        $first_player = $fate == 1 ? $this->white_army : $this->black_army;
        $second_player = $fate == 1 ? $this->black_army : $this->white_army;

        $current_player = $first_player;

        while( $current_player->can_move() )
        {
            $current_player->make_move();
            $current_player = $current_player == $first_player ? $second_player : $first_player;
        }

        var_dump($current_player);

    }
}

class Army
{
    public $units = [];
    public $enemy_units = [];
    public $name = "";
    public $kills = 0;

    function __construct($name = '')
    {
        for($i = 0; $i < MAX_UNITS_IN_ARMY; $i++)
        {
            array_push( $this->units, new Unit() );
        }
        $this->name = $name;
    }


    function make_move()
    {
        foreach($this->units as $unit)
        {
            $target_id = array_rand( $this->enemy_units );
            $target = $this->enemy_units[$target_id];
            $unit -> attack($target);

            if( !($target->is_valid()) ) # Enemy killed
            {
                unset( $this->enemy_units[$target_id] );
                $this->enemy_units = array_values($this->enemy_units);
                $this->kills++;
            }
        }
    }
    function can_move(): bool
    {
        return ($this->kills < 7);
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
        $this -> health = MAX_UNIT_HEALTH;
        $this -> damage = random_int(MIN_UNIT_DAMAGE, MAX_UNIT_DAMAGE);
    }

    function take_damage($damage)
    {
        $this->health -= $damage;

        if($this->health <= 0)
        {
            $this->active = false;
            $this->destroyed = true;
        }

    }

    function attack(Unit $target)
    {
        $target->take_damage( $this->damage );
    }

    function is_valid(): bool
    {
        return ($this->active and !($this->destroyed) );
    }
}

$game = new Game( new Army('white'), new Army('black') );

$game->main();

?>