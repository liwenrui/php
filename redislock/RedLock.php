<?php
/**
 * 单台redis加锁类
 * 要求
 * php-redis    2.2.4以上
 * redis        2.6.12以上
 * php          5.4以上
 * 参考redis官方分布式redis锁修改
 */
class RedLock{
    private $server   = array();
    private $instance = NULL;

    function __construct(array $server){
        $this->server = $server;
    }

    /**
     * 上锁
     */
    public function lock($resource, $ttl){
        $this->initInstance();

        $token = md5(uniqid(md5(microtime(true)),true));
        //设置锁
        if ($this->lockInstance($this->instance, $resource, $token, $ttl)) {
            return [
                'resource' => $resource,
                'token'    => $token,
            ];
        }

        return false;
    }

    /**
     * 删除锁
     */
    public function unlock(array $lock){
        $this->initInstance();
        $resource = $lock['resource'];
        $token    = $lock['token'];

        return $this->unlockInstance($this->instance, $resource, $token);
    }

    /**
     * 初始化redis
     */
    private function initInstance(){
        if (empty($this->instance)) {
            list($host, $port, $timeout) = $this->server;
            $redis = new Redis();
            $redis->connect($host, $port, $timeout);

            $this->instance = $redis;
        }
    }

    /**
     * 设置锁
     */
    private function lockInstance($instance, $resource, $token, $ttl){
        /**
         * EX seconds – 设置键key的过期时间，单位时秒
         * PX milliseconds – 设置键key的过期时间，单位时毫秒
         * NX – 只有键key不存在的时候才会设置key的值
         */
        //ttl必须是int不能是string否则过期时间就是永久了
        $ttl = intval($ttl);
        return $instance->set($resource, $token, ['NX', 'EX' => $ttl]);
    }

    /**
     * 删除锁
     */
    private function unlockInstance($instance, $resource, $token){
        $script = '
            if redis.call("GET", KEYS[1]) == ARGV[1] then
                return redis.call("DEL", KEYS[1])
            else
                return 0
            end
        ';
        return $instance->eval($script, [$resource, $token], 1);
    }

    /**
     * 临时测试用的,可以删除
     */
    public function tempSet($key,$value){
        $this->initInstance();
        $this->instance->set($key,$value);
    }

    /**
     * 临时测试用的,可以删除
     */
    public function tempGet($key){
        $this->initInstance();
        return $this->instance->get($key);
    }

}
