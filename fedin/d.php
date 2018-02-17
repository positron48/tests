<?php
/**
 * Task D. Маршрут построен
 * Author: Igor Fedin (iassasin@yandex.ru)
 * Requires php 7.1 to run
 */

require_once 'IO.php';

class Graph {
    private $nodes;
    private $links;

    public function __construct(){
        $this->nodes = [];
        $this->links = [];
    }

    public function addNode($name){
        if (array_key_exists($name, $this->nodes)){
            return;
        }

        $this->nodes[] = $name;
    }

    public function addLink($from, $to, $weight){
        $this->links[] = [$from, $to, $weight];
        $this->links[] = [$to, $from, $weight];
    }

    public function removeLinks($from, $to){
        $this->links = array_filter($this->links, function($el) use($from, $to){
            return !($from == $el[0] && $to == $el[1]
                || $to == $el[0] && $from == $el[1]);
        });
    }

    public function findLinks($from){
        return array_filter($this->links, function($el) use($from){
            return $from == $el[0];
        });
    }

    public function getShortestPathLength($from, $to){
        // Dijkstra: https://en.wikipedia.org/wiki/Dijkstra%27s_algorithm
        $visited = [$from];
        $toVisit = [$from];
        $costs = [];

        foreach ($this->nodes as $node){
            $costs[$node] = -1;
        }
        $costs[$from] = 0;

        // Make some tea. I hope in php it works fast
        while (count($toVisit) > 0){
            $current = array_shift($toVisit);
            $visited[] = $current;

            $cost = $costs[$current];
            $links = $this->findLinks($current);

            foreach ($links as $link){
                $lto = $link[1];
                $lcost = $link[2];

                if ($costs[$lto] == -1 || $costs[$lto] > $cost + $lcost) {
                    $costs[$lto] = $cost + $lcost;
                }

                if (!in_array($lto, $visited) && ! in_array($lto, $toVisit)){
                    $toVisit[] = $lto;
                }
            }
        }

        return $costs[$to];
    }
}

$io = new IO($argv[1]);
$graph = new Graph();

[$nodes, $links] = $io->scanf('%d %d');
for ($i = 0; $i < $nodes; ++$i){
    $graph->addNode($i);
}

for ($i = 0; $i < $links; ++$i){
    [$from, $to, $weight] = $io->scanf('%d %d %d');
    $graph->addLink($from, $to, $weight);
}

$reqsCount = $io->readIntLine();
for ($i = 0; $i < $reqsCount; ++$i){
    [$from, $to, $req] = $io->scanf('%d %d %s');

    if ($req == '?'){
        $io->writeLine($graph->getShortestPathLength($from, $to));
    }
    else if ($req == -1){
        $graph->removeLinks($from, $to);
    }
    else {
        $weight = (int) $req;
        $graph->removeLinks($from, $to);
        $graph->addLink($from, $to, $weight);
    }
}
