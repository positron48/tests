<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.02.18
 * Time: 13:28
 */

class Graph
{
    public $matrix;
    public $size;
    function __construct($size)
    {
        $this->size = $size;
        $this->matrix = array();
        for ($i = 0; $i < $size; $i++)
        {
            $this->matrix[] = array();
            for ($j = 0; $j < $size; $j++)
            {
                if ($i==$j)
                    $this->matrix[$i][$j] = 0;
                else
                    $this->matrix[$i][$j] = PHP_INT_MAX;
            }
        }
    }
    function createConnection($i, $j, $value)
    {
        if ($i > $this->size or $j > $this->size) return false;
        else if ($i == $j) return false;
        else
        {
            $this->matrix[$i][$j] = $value;
            $this->matrix[$j][$i] = $value;
        }
        return true;
    }
    function removeConnection($i, $j)
    {
        if ($i > $this->size or $j > $this->size) return false;
        else if ($i == $j) return false;
        else
        {
            $this->matrix[$i][$j] = PHP_INT_MAX;
            $this->matrix[$j][$i] = PHP_INT_MAX;
        }
        return true;
    }

    function getCost($start, $end)
    {
        $visited = array();
        $D = array();
        for($i = 0; $i < $this->size; $i++)
        {
            $D[] = $this->matrix[$start][$i];
            $visited[] = false;
        }
        $D[$start]=0;
        $index=0;
        $u=0;
        for ($i = 0; $i < $this->size; $i++)
        {
            $min = PHP_INT_MAX;
            for ($j = 0; $j < $this->size; $j++)
            {
                if (!$visited[$j] && $D[$j]<$min)
                {
                    $min=$D[$j];
                    $index=$j;
                }
            }
            $u=$index;
            $visited[$u]=true;
            for($j=0;$j < $this->size;$j++)
            {
                if ((!$visited[$j]) and ($this->matrix[$u][$j]!=PHP_INT_MAX) and ($D[$u]!= PHP_INT_MAX) and ($D[$u]+$this->matrix[$u][$j]<$D[$j]))
                {
                    $D[$j]=$D[$u]+$this->matrix[$u][$j];
                }
            }
        }
        if ($D[$end] < PHP_INT_MAX)
            return $D[$end];
        else
            return -1;
    }
}

$stdin = fopen('php://stdin', 'r');
$stdout = fopen('php://stdout', 'w');

$line = fgets($stdin);
$n = explode(" ", $line)[0];
$m = explode(" ", $line)[1];

$graph = new Graph($n);
for ($i = 0; $i < $m; $i++)
{
    $line = fgets($stdin);
    $array  = explode(" ", substr($line, 0, strlen($line) - 1));
    $graph->createConnection(intval($array[0]),intval($array[1]), intval($array[2]));
}

$maxRequests = intval(fgets($stdin));

for ($i = 0; $i < $maxRequests; $i++)
{
    $line = fgets($stdin);
    $array  = explode(" ", substr($line, 0, strlen($line) - 1));
    if ($array[2]=="?")
    {
        fwrite($stdout, $graph->getCost(intval($array[0]),intval($array[1]))."\n");
    }
    else if ($array[2]=="-1")
    {
        $graph->removeConnection(intval($array[0]),intval($array[1]));
    }
    else
    {
        $graph->createConnection(intval($array[0]),intval($array[1]), intval($array[2]));
    }
}

fclose($stdin);
fclose($stdout);