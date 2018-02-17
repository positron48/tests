<?php
/**
 * Helper class for input-output
 * Author: Igor Fedin (iassasin@yandex.ru)
 * Requires php 7.1 to run
 */

class IO {
    private $in;
    private $out;

    public function __construct(){
        $this->in = fopen('php://stdin', 'r');
        $this->out = fopen('php://stdout', 'w');
    }

    public function __destruct(){
        fclose($this->in);
        fclose($this->out);
    }

    public function readLine(){
        return substr(fgets($this->in), 0, -1);
    }

    public function readIntLine(){
        return (int) $this->readLine();
    }

    public function scanf($fmt){
        return fscanf($this->in, $fmt);
    }

    public function write(...$args){
        fwrite($this->out, join('', $args));
    }

    public function writeLine(...$args){
        fwrite($this->out, join('', $args)."\n");
    }

    public function printf(...$args){
        call_user_func_array('fprintf', array_merge([$this->out], $args));
    }
}
