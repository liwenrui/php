<?php
/**
 * php必须大于5.2.3
 * curl必须大于 7.16.2
 * curl_multi_init并发请求
 * CURLOPT_TIMEOUT_MS毫秒级
 */
include_once('interface.class.php');

class curlLog implements lejulogInterface{

    const LOG_SYSTEM_URL = 'http://api.liwenrui.com/xx.json';

    private $log_array = array();

    public function __construct(){
        //php必须大于5.2.3
        if(version_compare(PHP_VERSION,'5.2.3','<')) die('require PHP > 5.2.3 !');

        //curl必须大于 7.16.2
        if(!extension_loaded('curl')) die('require CURL');
        $curl_version = curl_version();
        if(version_compare($curl_version['version'],'7.16.2','<')) die('require CURL > 7.16.2 !');
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

    private function _params(){}

    public function __destruct(){
        $msg_array = $this->get();

        if(!empty($msg_array)){
            //起的进程数是根据php-fpm.conf里的pm.max_children决定的
            $mh = curl_multi_init();

            foreach ($msg_array as $key => $value) {
                $conn[$key] = curl_init();
                curl_setopt($conn[$key], CURLOPT_URL, self::LOG_SYSTEM_URL);
                curl_setopt($conn[$key], CURLOPT_HEADER , 0 ) ;
                curl_setopt($conn[$key], CURLOPT_POST, 1);
                $post_fields = http_build_query($value, '', '&');
                curl_setopt($conn[$key], CURLOPT_POSTFIELDS, $post_fields);
                //在cURL 7.16.2中被加入。从PHP 5.2.3起可使用
                curl_setopt($conn[$key], CURLOPT_TIMEOUT_MS, 1);//这是毫秒级别,但是这个函数有个bug，如果时间小于1000毫秒也就是1秒的话，会立马报错.增加 curl_setopt($ch, CURLOPT_NOSIGNAL, 1)就可以了
                curl_setopt($conn[$key], CURLOPT_NOSIGNAL, 1);
                curl_setopt($conn[$key], CURLOPT_RETURNTRANSFER,true);
                curl_multi_add_handle($mh, $conn[$key]);
            }

            do {
                curl_multi_exec($mh,$active);
            } while ($active);

            foreach($msg_array as $key => $value){
                curl_multi_remove_handle($mh,$conn[$key]);
                curl_close($conn[$key]);
            }

            curl_multi_close($mh);
        }

    }
}