<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.02.18
 * Time: 11:33
 */
$stdin = fopen('php://stdin', 'r');
$stdout = fopen('php://stdout', 'w');

class Bet
{
    public $game, $money, $field;
    function __construct($line)
    {
        $array = explode(" ", $line);
        $this->game = intval($array[0]);
        $this->money = intval($array[1]);
        $this->field = $array[2];
    }
}
class Game
{
    public $id, $coefL, $coefR, $coefD, $winner;
    function __construct($line)
    {
        $array = explode(" ", $line);
        $this->id = intval($array[0]);
        $this->coefL = floatval($array[1]);
        $this->coefR = floatval($array[2]);
        $this->coefD = floatval($array[3]);
        $this->winner = $array[4];
    }
}

$n = fgets($stdin); //named right after task
$bets = array();
for ($i = 0; $i < $n; $i++)
{
    $line = fgets($stdin);
    $bet = new Bet(substr($line, 0, strlen($line) - 1));
    array_push($bets, $bet);
}

$m = fgets($stdin);
$balance = 0;
for ($i = 0; $i < $m; $i++)
{
    $line = fgets($stdin);
    $game = new Game(substr($line, 0, strlen($line) - 1));
    foreach ($bets as $bet)
    {
        if ($bet->game==$game->id)
        {
            if ($bet->field==$game->winner)
            {
                if (property_exists($game, "coef".$game->winner)) {
                    $balance += $bet->money * $game->{"coef" . $game->winner};
                }
            }
            $balance -= $bet->money;
        }
    }
}
fwrite($stdout, $balance."\n");


fclose($stdin);
fclose($stdout);

?>