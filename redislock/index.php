<?php
/**
 * 欢迎交流php 并发锁
 * @author 李文瑞 <164798922@qq.com>
 */
header("Content-type: text/html; charset=utf-8");
require_once __DIR__ . '/RedLock.php';

$server = ['192.168.56.101', 6379, 2];

$redLock = new RedLock($server);


try {
    $status = TRUE;
    while ($status) {
        //上锁
        $lock = $redLock->lock('164798922@qq.com', 20);//20秒超时
        var_dump($lock);
        if($lock){
            //todo something
            /**
              模拟请求次数
              第一次请求延迟5秒
              第二次请求立即
             */
            /**
             ########################################################
             */
            $count = $redLock->tempGet('lwr:lock:request:count');
            if(!$count){
                sleep(5);
                $redLock->tempSet('lwr:lock:request:count',1);
            }
            /**
             ########################################################
             */

            //如果锁删除失败,说明已经失效.那就有可能被别的线程获取到.所以应该回滚了.
            $delLock = $redLock->unlock($lock);
            if(!$delLock){
                throw new Exception("下单失败", 1);
            }

            //事物提交

            //结束while循环
            $status = FALSE;
            echo '下单成功';
            echo '<hr>';
        }else{
            //todo 要做成类似while.等待1秒后继续上锁
            sleep(1);
        }
    }

} catch (Exception $e) {
    //回滚
    var_dump($e->getMessage());
}

