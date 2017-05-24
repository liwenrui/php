<?php

interface lejulogInterface{
    public function __construct();

    public function add($type,$data);

    public function get();

    public function __destruct();
}
