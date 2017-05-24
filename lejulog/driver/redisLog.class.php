<?php
include_once('interface.class.php');

class redisLog implements lejulogInterface{

    //日志系统的队列名称
    const LOG_KEY = 'api:liwenrui:redis:log';

    private $log_array = array();
    private $_instance_master;

    public function __construct(){
        //必须装有redis扩展
        if(!extension_loaded('redis')) die('require REDIS');

        $this->_instance_master = new Redis;
        try {
            list($redis_addr, $redis_port) = explode(':', $_SERVER['SINASRV_REDIS_HOST']);
            $this->_instance_master->connect($redis_addr, $redis_port);
        } catch (Exception $e) {
            throw new ErrorException("Connect redis server master fail !");
        }

    }

    public function add($type,$data){
        $this->log_array[] = array(
                'type' => $type,
                'data' => $data,
            );
    }

    public function get(){
        return $this->log_array;
    }

    public function __destruct(){
        //写入redis
        $msg_array = $this->get();
        if(!empty($msg_array)){
            foreach ($msg_array as $key => $value) {
                $this->_instance_master->LPUSH(self::LOG_KEY, serialize($value));
            }
        }
    }
}