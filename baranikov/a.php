<?
error_reporting(0);
	// common parts
	//$input = file('input_a.txt');
	$input = file($argv[1]);
	//var_dump($input);
	//task a

	class Bet{
		public $id;
		public $bet;
		public $result;
        function __construct($a,$s,$r)
        {
			$this->id = $a;
			$this->bet = $s;
			$this->result = $r;
        }
	}

	class Game{
        public $id;
        public $left;
        public $right;
        public $both;
        public $result;

    	function __construct($b,$c,$d,$k,$t)
		{
			$this->id = $b;
			$this->left = $c;
			$this->right = $d;
			$this->both = $k;
			$this->result = $t;
		}
		function getAnswer($res)
		{

		}

    }

	function getAnswer($game, $res)
	{
		//$res = trim($res);
		switch ($res)
		{
			case "L":
				//var_dump((double)$game[1]);
				return (double)$game[1];
			case "R":
				return (double)$game[2];
			case "D":
				return (double)$game[3];
		}
	}

	$n = $input[0];
	$m = $input[(int)$n+1];
	$profit = 0;
	$bets = [];
	$games= [];
	// fill bets
	for ($i=0 ; $i<$n ; $i++)
	{
		$tmpBet = explode(' ',$input[$i+1]);
		// choose the game for this bet
		$tmpGame= explode(' ',$input[(int)($n + $tmpBet[0] + 1)]);

		//$bets[$i] = new Bet($tmpBet[0],$tmpBet[1],$tmpBet[2]);

		// remove the spaces
        $tmpGame[4] = trim($tmpGame[4]);
        $tmpBet[2] = trim($tmpBet[2]);
        // equate profit
		if ($tmpBet[2] != $tmpGame[4])
			$profit -= $tmpBet[1];
		else
			$profit += $tmpBet[1] * getAnswer($tmpGame,$tmpBet[2]);

	}
	// file_put_content
	file_put_contents('output.txt', $profit);
	echo $profit;



	//fill gasmes
	/*for ($i=0 ; $i<$m ; $i++)
	{
		$tmpBet = explode(' ',$input[$n + $i+1]);
		$bets[$i] = new Bet($tmpBet[0],$tmpBet[1],$tmpBet[2]);
	}*/
	//var_dump($bets);



?>
