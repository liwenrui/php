<?php

/**
 * 日志类
 */
class LeJuLog{

    static public $send_handler = '';

    /**
     * 添加日志
     */
    static public function add($type,$data){
        if(empty(self::$send_handler)){
            self::init();
        }

        if(!empty($type) && !empty($data)){
            self::$send_handler->add($type,$data);
        }
    }


    /**
     * 初始化日志handler
     */
    static private function init(){
        $config     = include_once('config.php');
        $class_name = $config['SEND_TYPE'];

        include_once('driver' . DIRECTORY_SEPARATOR . $class_name . '.class.php');
        self::$send_handler =  new $class_name();
    }


}