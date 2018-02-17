<?php

    // common parts
    //$input = file('input_a.txt');
    $input = file($argv[1]);
    $output = [];

    class Block
    {
        public $value;
        public $count;


        function getBlock($inputBlock)
        {

            $tmpBlocks = explode(':', $inputBlock);
            //var_dump($tmpBlocks);
            foreach ($tmpBlocks as $block) {
                $length = 4 - strlen($block);
                $this->value .= str_repeat('0', $length) . $block . ':';
            }
            $this->count = count($tmpBlocks);
        }
    }
    //


    for ($i = 0 ; $i < count($input) ; $i++)
    {
        $output[$i] = "";
        // get the part
        // determine the zero sequences
        $tmpPart = explode('::',trim($input[$i]));
        //var_dump($tmpPart);
        if(count($tmpPart)== 1)
        {
            // there's no sequences. good
            $tmpBlocks = new Block();
            $tmpBlocks->getBlock($tmpPart[0]);
            $output[$i] .= $tmpBlocks->value;
        }
        else
        {
            // get blocks before '::'
            $leftBlocks = new Block();
            $leftBlocks->getBlock($tmpPart[0]);

            // get blocks after '::'
            $rightBlocks = new Block();
            $rightBlocks->getBlock($tmpPart[1]);

            // get count of zero sequences
            $length = 8 - ($leftBlocks->count + $rightBlocks->count);

            // form output
            $output[$i] .= $leftBlocks->value . str_repeat('0000:',$length) . $rightBlocks->value;

        }
        // delete the ':' symbol at the end
//        $output[$i] = substr($output[$i] ,0,strlen($output[$i]) - 1);
        if (strlen($output[$i]) > (5*8-1))
        $output[$i] = substr($output[$i] ,0,(5*8-1));
    }
    //var_dump($output);
    foreach ($output as $line)
        echo $line . PHP_EOL;

?>