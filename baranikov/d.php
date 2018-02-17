<?php

    // common parts
    //$input = file('input_a.txt');
    $input = file('input_d.txt');
    $output = [];

    class Node
    {
        public $id;
        public $relations;

        function __construct($id)
        {
            $this->id = $id;
        }
        function setRel($node, $time=-1)
        {
            $this->relations[$node] = $time;
        }

    }

    class Nodes
    {
        public $nodes;
        function setTime($relation)
        {
            $tmp = $relation;
            $this->nodes[$tmp[0]]->setRel($tmp[1], $tmp[2]);
            $this->nodes[$tmp[1]]->setRel($tmp[0], $tmp[2]);
        }
    }

    function equatePath($route, $path, $node)
    {

    }
    $nodesData = explode(' ',$input[0]);

    $nodes = new Nodes();
    //create nodes
    for ($i = 0 ; $i < $nodesData[0] ; $i++)
        $nodes->nodes[$i] = new Node($i);

    for ($i = 0 ; $i < $nodesData[1] ; $i++)
    {
        $tmp = explode(' ',trim($input[$i + 1]));

        // set relations for nodes
        $nodes->setTime($tmp);

    }
    var_dump($nodes);
    $requestCount = $input[$nodesData[1] + 1];

    for ($i = 0 ; $i < $requestCount ; $i++)
    {
        $route = str_repeat('0',$nodesData[0]);

        $tmp = explode(' ',trim($input[$nodesData[1] + 1 + $i + 1]));

        $route[$tmp[0]] = '1';
        echo '<br>$route<br>';

        if (trim($tmp[2])== '?')
        {
            // find the fastest route
                 //should rewrite data structure
            // should be recursive
            for ( $i = 0 ; $i < $nodesData[0] )
            {
                if ($route[$i] != '1')
                {
                   $paths[] = equatePath($route,$path,$nodes->nodes[$tmp[0]]);
                }
                if ($nodes->nodes[$tmp[0]]->relations[$tmp[1]] != -1 && isset($nodes->nodes[$tmp[0]]->relations[$tmp[1]] ))
                {
                    array_push($route, $nodes->nodes[$tmp[0]]->relations[$tmp[1]]);

                }
            }

        }
        else
        {
            // set the time
            $nodes->setTime($tmp);
        }
        var_dump($route);
    }


    var_dump($output);

?>